<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Support\StudentStatusPresenter;
use Illuminate\Support\Facades\Storage;

class PendaftaranProgressService
{
    private const BIODATA_FIELDS = [
        'full_name',
        'email',
        'asal_sekolah',
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
        'photo_path',
        'program_studi_id',
        'gelombang_pendaftaran_id',
    ];

    private const DOCUMENT_FIELDS = [
        'id_card_path',
        'family_card_path',
        'diploma_path',
        'transcript_path',
    ];

    public function calculate(Pendaftaran $pendaftaran): array
    {
        $biodata = $this->calculateGroup($pendaftaran, self::BIODATA_FIELDS);
        $documents = $this->calculateDocuments($pendaftaran);
        $status = $pendaftaran->status;
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
            'percentage' => $this->displayPercentage($status, min(100, $percentage)),
            'current_step' => $this->currentStep($biodata['complete'], $documents['complete'], $submitted),
            'missing_steps' => $this->missingSteps($biodata, $documents, $submitted),
            'show_missing_steps' => $this->shouldShowMissingSteps($status),
            'dashboard_notice' => $this->dashboardNotice($pendaftaran),
            'biodata' => $biodata,
            'documents' => $documents,
            'submitted' => $submitted,
            'status' => [
                'label' => $this->statusLabel($pendaftaran->status),
                'badge' => $this->statusBadge($pendaftaran->status),
            ],
            'steps' => $this->steps($pendaftaran->status, $biodata, $documents, $submitted),
        ];
    }

    private function calculateGroup(Pendaftaran $pendaftaran, array $fields): array
    {
        $missingFields = collect($fields)
            ->filter(fn (string $field) => $this->fieldMissing($pendaftaran, $field))
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

    private function fieldMissing(Pendaftaran $pendaftaran, string $field): bool
    {
        if ($field === 'photo_path') {
            return ! $this->documentExists($pendaftaran->photo_path);
        }

        return blank($pendaftaran->{$field});
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

    private function shouldShowMissingSteps(?string $status): bool
    {
        return in_array($status, ['draft', 'in_progress', 'documents_uploaded'], true);
    }

    private function dashboardNotice(Pendaftaran $pendaftaran): ?array
    {
        return match ($pendaftaran->status) {
            'submitted', 'under_review' => [
                'title' => 'Formulir sudah dikirim.',
                'message' => 'Pendaftaran Anda telah dikirim dan sedang menunggu review admin.',
                'tone' => 'info',
            ],
            'verified', 'accepted' => [
                'title' => 'Pendaftaran disetujui.',
                'message' => 'Pendaftaran Anda telah disetujui. Silakan ikuti instruksi berikutnya pada portal PMB.',
                'tone' => 'success',
            ],
            'revision_required' => [
                'title' => 'Perlu revisi data.',
                'message' => $pendaftaran->catatan_admin ?: 'Admin meminta perbaikan data atau dokumen. Periksa kembali formulir pendaftaran Anda.',
                'tone' => 'warning',
            ],
            'rejected' => [
                'title' => 'Pendaftaran ditolak.',
                'message' => $pendaftaran->catatan_admin ?: 'Pendaftaran Anda ditolak. Silakan hubungi admin PMB untuk informasi lebih lanjut.',
                'tone' => 'danger',
            ],
            default => null,
        };
    }

    private function displayPercentage(?string $status, int $calculatedPercentage): int
    {
        return match ($status) {
            'submitted', 'under_review' => max($calculatedPercentage, 100),
            'verified', 'accepted' => 100,
            'rejected' => max($calculatedPercentage, 100),
            default => $calculatedPercentage,
        };
    }

    private function stepState(bool $complete, bool $active): string
    {
        if ($complete) {
            return 'completed';
        }

        return $active ? 'current' : 'upcoming';
    }

    private function steps(?string $status, array $biodata, array $documents, bool $submitted): array
    {
        if (in_array($status, ['submitted', 'under_review', 'verified', 'accepted'], true)) {
            return [
                'biodata' => 'completed',
                'documents' => 'completed',
                'submission' => 'completed',
            ];
        }

        return [
            'biodata' => $this->stepState($biodata['complete'], ! $biodata['complete']),
            'documents' => $this->stepState($documents['complete'], $biodata['complete'] && ! $documents['complete']),
            'submission' => $this->stepState($submitted, $biodata['complete'] && $documents['complete'] && ! $submitted),
        ];
    }

    private function statusLabel(?string $status): string
    {
        return StudentStatusPresenter::label($status);
    }

    private function statusBadge(?string $status): string
    {
        return StudentStatusPresenter::badge($status);
    }
}
