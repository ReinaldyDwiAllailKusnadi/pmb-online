<?php

namespace App\Console\Commands;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CleanLegacyApplicants extends Command
{
    protected $signature = 'pmb:clean-legacy-applicants
        {--apply : Apply changes. Without this option the command only logs a dry-run plan.}
        {--delete-unmatched-orphans : Delete applicants without user_id and without matching user email. Requires --apply.}
        {--unknown-status=draft : Canonical status to use for unknown legacy status values.}';

    protected $description = 'Safely clean legacy applicant rows by linking users, merging orphans, and normalizing statuses.';

    private const CANONICAL_STATUSES = [
        'draft',
        'in_progress',
        'documents_uploaded',
        'submitted',
        'under_review',
        'revision_required',
        'verified',
        'rejected',
        'accepted',
    ];

    private const STATUS_ALIASES = [
        'draft' => 'draft',
        'new' => 'draft',
        'baru' => 'draft',
        'in-progress' => 'in_progress',
        'in_progress' => 'in_progress',
        'progress' => 'in_progress',
        'sedang-dilengkapi' => 'in_progress',
        'dokumen-terunggah' => 'documents_uploaded',
        'documents-uploaded' => 'documents_uploaded',
        'documents_uploaded' => 'documents_uploaded',
        'submitted' => 'submitted',
        'terkirim' => 'submitted',
        'pending' => 'submitted',
        'under-review' => 'under_review',
        'under_review' => 'under_review',
        'review' => 'under_review',
        'menunggu-verifikasi' => 'under_review',
        'revision-required' => 'revision_required',
        'revision_required' => 'revision_required',
        'revision' => 'revision_required',
        'revisi' => 'revision_required',
        'perlu-revisi' => 'revision_required',
        'verified' => 'verified',
        'verified-by-admin' => 'verified',
        'diverifikasi' => 'verified',
        'approved' => 'verified',
        'rejected' => 'rejected',
        'reject' => 'rejected',
        'ditolak' => 'rejected',
        'accepted' => 'accepted',
        'diterima' => 'accepted',
        'lulus' => 'accepted',
    ];

    private const MERGEABLE_COLUMNS = [
        'full_name',
        'email',
        'address',
        'current_address',
        'district',
        'city',
        'province',
        'home_phone',
        'phone',
        'citizen',
        'birth_place',
        'birth_day',
        'birth_month',
        'birth_year',
        'gender',
        'marital',
        'religion',
        'photo_path',
        'id_card_path',
        'family_card_path',
        'diploma_path',
        'transcript_path',
        'nomor_pendaftaran',
        'program_studi_id',
        'gelombang_pendaftaran_id',
        'catatan_admin',
        'submitted_at',
        'verified_at',
        'verified_by',
    ];

    private string $logPath;

    private bool $apply = false;

    public function handle(): int
    {
        $this->apply = (bool) $this->option('apply');
        $unknownStatus = (string) $this->option('unknown-status');

        if (! in_array($unknownStatus, self::CANONICAL_STATUSES, true)) {
            $this->error('The --unknown-status value must be one of: ' . implode(', ', self::CANONICAL_STATUSES));

            return self::FAILURE;
        }

        if ($this->option('delete-unmatched-orphans') && ! $this->apply) {
            $this->warn('--delete-unmatched-orphans was ignored because this is a dry-run.');
        }

        $this->logPath = 'legacy-cleanup/applicants-' . now()->format('Ymd-His') . '-' . Str::random(6) . '.jsonl';
        $this->info(($this->apply ? 'APPLY' : 'DRY-RUN') . ' mode. Log: ' . Storage::disk('local')->path($this->logPath));

        $summary = DB::transaction(function () use ($unknownStatus) {
            $summary = [
                'linked' => 0,
                'merged' => 0,
                'deleted_merged' => 0,
                'deleted_unmatched_orphans' => 0,
                'skipped_orphans' => 0,
                'normalized_statuses' => 0,
            ];

            Pendaftaran::query()
                ->orderBy('id')
                ->get()
                ->each(function (Pendaftaran $applicant) use (&$summary, $unknownStatus) {
                    $this->normalizeStatus($applicant, $unknownStatus, $summary);
                    $this->repairUserLink($applicant, $summary);
                });

            return $summary;
        });

        $this->newLine();
        $this->table(['Action', 'Count'], collect($summary)->map(fn ($count, $action) => [$action, $count])->all());
        $this->info('Cleanup log written to: ' . Storage::disk('local')->path($this->logPath));

        if (! $this->apply) {
            $this->warn('Dry-run only. Re-run with --apply after reviewing the log.');
        }

        return self::SUCCESS;
    }

    private function normalizeStatus(Pendaftaran $applicant, string $unknownStatus, array &$summary): void
    {
        $current = (string) $applicant->status;
        $normalized = $this->canonicalStatus($current, $unknownStatus);

        if ($current === $normalized) {
            return;
        }

        $this->log('normalize_status', $applicant, [
            'from' => $current,
            'to' => $normalized,
        ]);

        $summary['normalized_statuses']++;

        if ($this->apply) {
            $applicant->forceFill(['status' => $normalized])->save();
        }
    }

    private function repairUserLink(Pendaftaran $applicant, array &$summary): void
    {
        if ($applicant->user_id) {
            return;
        }

        $matchedUser = User::query()
            ->whereRaw('LOWER(email) = ?', [mb_strtolower((string) $applicant->email)])
            ->first();

        if (! $matchedUser) {
            $this->handleUnmatchedOrphan($applicant, $summary);

            return;
        }

        $existing = Pendaftaran::query()
            ->where('user_id', $matchedUser->id)
            ->whereKeyNot($applicant->id)
            ->first();

        if (! $existing) {
            $this->log('assign_user_id', $applicant, [
                'user_id' => $matchedUser->id,
                'email' => $matchedUser->email,
            ]);

            $summary['linked']++;

            if ($this->apply) {
                $applicant->forceFill(['user_id' => $matchedUser->id])->save();
            }

            return;
        }

        $this->mergeApplicantInto($applicant, $existing, $matchedUser, $summary);
    }

    private function mergeApplicantInto(Pendaftaran $source, Pendaftaran $target, User $user, array &$summary): void
    {
        $updates = [];

        foreach (self::MERGEABLE_COLUMNS as $column) {
            if (! array_key_exists($column, $source->getAttributes()) || ! array_key_exists($column, $target->getAttributes())) {
                continue;
            }

            if (blank($target->{$column}) && filled($source->{$column})) {
                $updates[$column] = $source->{$column};
            }
        }

        $sourceStatus = $this->canonicalStatus((string) $source->status, 'draft');
        $targetStatus = $this->canonicalStatus((string) $target->status, 'draft');

        if ($this->statusRank($sourceStatus) > $this->statusRank($targetStatus)) {
            $updates['status'] = $sourceStatus;
        }

        $this->log('merge_orphan_into_existing_applicant', $source, [
            'target_applicant_id' => $target->id,
            'user_id' => $user->id,
            'merged_columns' => array_keys($updates),
            'delete_source_after_merge' => $this->apply,
        ]);

        $summary['merged']++;

        if (! $this->apply) {
            return;
        }

        if ($updates !== []) {
            $target->forceFill($updates)->save();
        }

        DB::table('status_histories')
            ->where('pendaftaran_id', $source->id)
            ->update(['pendaftaran_id' => $target->id]);

        $source->delete();
        $summary['deleted_merged']++;
    }

    private function handleUnmatchedOrphan(Pendaftaran $applicant, array &$summary): void
    {
        $shouldDelete = $this->apply && (bool) $this->option('delete-unmatched-orphans');

        $this->log($shouldDelete ? 'delete_unmatched_orphan' : 'skip_unmatched_orphan', $applicant, [
            'reason' => 'No users.email match was found for applicant email.',
            'delete_requires' => '--apply --delete-unmatched-orphans',
        ]);

        if ($shouldDelete) {
            $applicant->delete();
            $summary['deleted_unmatched_orphans']++;

            return;
        }

        $summary['skipped_orphans']++;
    }

    private function canonicalStatus(string $status, string $fallback): string
    {
        $key = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($status)), '-');

        return self::STATUS_ALIASES[$key] ?? $fallback;
    }

    private function statusRank(string $status): int
    {
        return array_search($status, self::CANONICAL_STATUSES, true) ?: 0;
    }

    private function log(string $action, Pendaftaran $applicant, array $context = []): void
    {
        Storage::disk('local')->append($this->logPath, json_encode([
            'logged_at' => now()->toISOString(),
            'mode' => $this->apply ? 'apply' : 'dry-run',
            'action' => $action,
            'applicant_id' => $applicant->id,
            'applicant_email' => $applicant->email,
            'applicant_user_id' => $applicant->user_id,
            'context' => $context,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
