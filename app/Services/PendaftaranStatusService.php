<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PendaftaranStatusService
{
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

    private const ALLOWED_TRANSITIONS = [
        'draft' => ['in_progress'],
        'in_progress' => ['documents_uploaded', 'submitted'],
        'documents_uploaded' => ['submitted'],
        'submitted' => ['under_review'],
        'under_review' => ['verified', 'rejected', 'revision_required'],
        'revision_required' => ['documents_uploaded', 'submitted'],
        'verified' => ['accepted'],
    ];

    public function transition(Pendaftaran $pendaftaran, string $statusTo, ?User $actor = null, ?string $note = null, array $updates = []): Pendaftaran
    {
        return DB::transaction(function () use ($pendaftaran, $statusTo, $actor, $note, $updates) {
            $locked = Pendaftaran::query()->whereKey($pendaftaran->id)->lockForUpdate()->firstOrFail();
            $statusFrom = $locked->status;

            if ($statusFrom === $statusTo) {
                // Repeated clicks should be idempotent: no duplicate history and no timestamp/note overwrite.
                return $locked;
            }

            $this->assertAllowed($statusFrom, $statusTo);
            $this->assertRequiredNote($statusTo, $note);

            $locked->update(array_merge($updates, [
                'status' => $statusTo,
            ]));

            DB::table('status_histories')->insert([
                'pendaftaran_id' => $locked->id,
                'user_id' => $actor?->id,
                'status_from' => $statusFrom,
                'status_to' => $statusTo,
                'catatan' => $note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $locked;
        });
    }

    public function assertAllowed(?string $statusFrom, string $statusTo): void
    {
        if (! in_array($statusFrom, self::CANONICAL_STATUSES, true)) {
            throw ValidationException::withMessages([
                'status' => 'Status asal tidak dikenal: ' . ($statusFrom ?: '-'),
            ]);
        }

        if (! in_array($statusTo, self::CANONICAL_STATUSES, true)) {
            throw ValidationException::withMessages([
                'status' => 'Status tujuan tidak dikenal: ' . $statusTo,
            ]);
        }

        if (in_array($statusTo, self::ALLOWED_TRANSITIONS[$statusFrom] ?? [], true)) {
            return;
        }

        throw ValidationException::withMessages([
            'status' => sprintf(
                'Transisi status dari %s ke %s tidak diperbolehkan.',
                $this->label($statusFrom),
                $this->label($statusTo)
            ),
        ]);
    }

    public function label(?string $status): string
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'Sedang Dilengkapi',
            'documents_uploaded' => 'Dokumen Terunggah',
            'submitted' => 'Terkirim',
            'under_review' => 'Menunggu Verifikasi',
            'revision_required' => 'Perlu Revisi',
            'verified' => 'Diverifikasi',
            'rejected' => 'Ditolak',
            'accepted' => 'Diterima',
        ][$status] ?? ucfirst((string) $status);
    }

    public function allowedTransitionsFor(?string $status): array
    {
        return self::ALLOWED_TRANSITIONS[$status] ?? [];
    }

    private function assertRequiredNote(string $statusTo, ?string $note): void
    {
        if (! in_array($statusTo, ['rejected', 'revision_required'], true)) {
            return;
        }

        if (! blank($note)) {
            return;
        }

        throw ValidationException::withMessages([
            'catatan_admin' => 'Catatan admin wajib diisi untuk status ' . $this->label($statusTo) . '.',
        ]);
    }
}
