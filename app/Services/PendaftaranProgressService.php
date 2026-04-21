<?php

namespace App\Services;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class PendaftaranProgressService
{
    private const BIODATA_FIELDS = [
        'full_name',
        'email',
        'address',
        'current_address',
        'district',
        'city',
        'province',
        'phone',
        'citizen',
        'birth_place',
        'birth_day',
        'birth_month',
        'birth_year',
        'gender',
        'marital',
        'religion',
        'program_studi_id',
        'gelombang_pendaftaran_id',
    ];

    private const DOCUMENT_FIELDS = [
        'photo_path',
        'id_card_path',
        'family_card_path',
        'diploma_path',
        'transcript_path',
    ];

    public function calculate(Pendaftaran $pendaftaran): array
    {
        $biodata = $this->calculateGroup($pendaftaran, self::BIODATA_FIELDS);
        $documents = $this->calculateDocuments($pendaftaran);
        $submitted = in_array($pendaftaran->status, [
            'submitted',
            'under_review',
            'revision_required',
            'verified',
            'rejected',
            'accepted',
        ], true);

        $percentage = (int) round(
            ($biodata['percentage'] * 0.4)
            + ($documents['percentage'] * 0.4)
            + ($submitted ? 20 : 0)
        );

        return [
            'percentage' => min(100, $percentage),
            'current_step' => $this->currentStep($biodata['complete'], $documents['complete'], $submitted),
            'missing_steps' => $this->missingSteps($biodata, $documents, $submitted),
            'biodata' => $biodata,
            'documents' => $documents,
            'submitted' => $submitted,
            'status' => [
                'label' => $this->statusLabel($pendaftaran->status),
                'badge' => $this->statusBadge($pendaftaran->status),
            ],
            'steps' => [
                'biodata' => $this->stepState($biodata['complete'], ! $biodata['complete']),
                'documents' => $this->stepState($documents['complete'], $biodata['complete'] && ! $documents['complete']),
                'submission' => $this->stepState($submitted, $biodata['complete'] && $documents['complete'] && ! $submitted),
            ],
        ];
    }

    private function calculateGroup(Pendaftaran $pendaftaran, array $fields): array
    {
        $missingFields = collect($fields)
            ->filter(fn (string $field) => blank($pendaftaran->{$field}))
            ->values()
            ->all();

        $filled = count($fields) - count($missingFields);

        return [
            'complete' => count($missingFields) === 0,
            'percentage' => (int) round(($filled / count($fields)) * 100),
            'missing_fields' => $missingFields,
        ];
    }

    private function calculateDocuments(Pendaftaran $pendaftaran): array
    {
        $missingFields = collect(self::DOCUMENT_FIELDS)
            ->filter(fn (string $field) => ! $this->documentExists($pendaftaran->{$field}))
            ->values()
            ->all();

        $filled = count(self::DOCUMENT_FIELDS) - count($missingFields);

        return [
            'complete' => count($missingFields) === 0,
            'percentage' => (int) round(($filled / count(self::DOCUMENT_FIELDS)) * 100),
            'missing_fields' => $missingFields,
        ];
    }

    private function documentExists(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        foreach (['local', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return true;
            }
        }

        return false;
    }

    private function currentStep(bool $biodataComplete, bool $documentsComplete, bool $submitted): string
    {
        if (! $biodataComplete) {
            return 'biodata';
        }

        if (! $documentsComplete) {
            return 'documents';
        }

        if (! $submitted) {
            return 'submission';
        }

        return 'completed';
    }

    private function missingSteps(array $biodata, array $documents, bool $submitted): array
    {
        $missing = [];

        if (! $biodata['complete']) {
            $missing[] = 'Lengkapi biodata pendaftar.';
        }

        if (! $documents['complete']) {
            $missing[] = 'Unggah seluruh dokumen wajib.';
        }

        if ($biodata['complete'] && $documents['complete'] && ! $submitted) {
            $missing[] = 'Kirim pendaftaran final.';
        }

        return $missing;
    }

    private function stepState(bool $complete, bool $active): string
    {
        if ($complete) {
            return 'completed';
        }

        return $active ? 'current' : 'upcoming';
    }

    private function statusLabel(?string $status): string
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'Sedang Dilengkapi',
            'documents_uploaded' => 'Dokumen Terunggah',
            'submitted' => 'Terkirim',
            'under_review' => 'Menunggu Review',
            'revision_required' => 'Perlu Revisi',
            'verified' => 'Diverifikasi',
            'rejected' => 'Ditolak',
            'accepted' => 'Diterima',
        ][$status] ?? ucfirst((string) $status);
    }

    private function statusBadge(?string $status): string
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'Progress',
            'documents_uploaded' => 'Documents',
            'submitted' => 'Submitted',
            'under_review' => 'Review',
            'revision_required' => 'Revision',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted',
        ][$status] ?? 'Status';
    }
}
