<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Support\StudentStatusPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StatusPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $applicant = $this->getApplicant($request)->loadMissing(['programStudi', 'gelombangPendaftaran']);
        $authUser = $request->user();

        $sidebarLinks = [
            [
                'icon' => 'bi bi-grid-1x2',
                'label' => 'Beranda',
                'active' => false,
                'href' => route('dashboard'),
            ],
            [
                'icon' => 'bi bi-file-text',
                'label' => 'Formulir Pendaftaran',
                'active' => false,
                'href' => route('form.step1'),
            ],
            [
                'icon' => 'bi bi-clipboard-check',
                'label' => 'Status Pendaftaran',
                'active' => true,
                'href' => route('status.pendaftaran'),
            ],
            [
                'icon' => 'bi bi-file-earmark-arrow-down',
                'label' => 'Unduh Bukti PDF',
                'active' => false,
                'href' => route('mahasiswa.unduh-bukti'),
            ],
        ];

        $histories = DB::table('status_histories')
            ->where('pendaftaran_id', $applicant->id)
            ->orderBy('created_at')
            ->get();

        $timelineSteps = $histories->map(function ($history, int $index) use ($histories) {
            return [
                'id' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'title' => $this->statusLabel($history->status_to),
                'date' => $history->created_at
                    ? \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y')
                    : '-',
                'status' => $index === $histories->count() - 1 ? 'current' : 'completed',
                'subtitle' => $history->catatan ?: $this->statusTransitionText($history->status_from, $history->status_to),
            ];
        })->all();

        $activityLog = $histories->sortByDesc('created_at')->map(function ($history) {
            return [
                'date' => $history->created_at
                    ? \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y, H:i')
                    : '-',
                'activity' => $this->statusLabel($history->status_to),
                'description' => $history->catatan ?: $this->statusTransitionText($history->status_from, $history->status_to),
                'color' => $this->statusColor($history->status_to),
            ];
        })->values()->all();

        $user = [
            'name' => $applicant->full_name ?: $authUser->name,
            'regNo' => $applicant->nomor_pendaftaran ?: 'PMB-' . str_pad((string) $applicant->id, 5, '0', STR_PAD_LEFT),
            'avatar' => $this->documentExists($applicant->photo_path)
                ? route('mahasiswa.dokumen.show', 'photo')
                : 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name ?: $authUser->name),
        ];

        $currentStatus = [
            'key' => $applicant->status,
            'label' => $this->statusLabel($applicant->status),
            'badge' => $this->statusBadge($applicant->status),
            'description' => $this->statusDescription($applicant->status),
            'icon' => $this->statusIcon($applicant->status),
        ];

        $selectedProgramStudi = $applicant->relationLoaded('programStudi')
            ? $applicant->getRelation('programStudi')
            : $applicant->programStudi()->first();
        $selectedGelombang = $applicant->relationLoaded('gelombangPendaftaran')
            ? $applicant->getRelation('gelombangPendaftaran')
            : $applicant->gelombangPendaftaran()->first();

        $catatanAdmin = $applicant->catatan_admin;
        $programInfo = [
            'program' => $applicant->program_studi ?: '-',
            'fakultas' => $selectedProgramStudi?->fakultas ?: '-',
            'gelombang' => $selectedGelombang?->nama ?: '-',
        ];

        return view('mahasiswa.status-pendaftaran', compact(
            'sidebarLinks',
            'timelineSteps',
            'activityLog',
            'user',
            'currentStatus',
            'catatanAdmin',
            'programInfo'
        ));
    }

    private function getApplicant(Request $request): Pendaftaran
    {
        $user = $request->user();

        return Pendaftaran::query()->createOrFirst(['user_id' => $user->id], [
            'full_name' => $user->name,
            'email' => $user->email,
            'status' => 'draft',
        ]);
    }

    private function statusLabel(?string $status): string
    {
        return StudentStatusPresenter::label($status);
    }

    private function statusDescription(?string $status): string
    {
        return [
            'draft' => 'Pendaftaran Anda masih berupa draft. Lengkapi formulir dan dokumen untuk melanjutkan.',
            'in_progress' => 'Data pendaftaran sedang dilengkapi. Pastikan semua informasi dan dokumen sudah benar.',
            'documents_uploaded' => 'Seluruh dokumen wajib telah diunggah. Silakan kirim pendaftaran final untuk masuk antrean admin.',
            'submitted' => 'Pendaftaran Anda telah dikirim dan masuk ke antrean pemeriksaan admin.',
            'under_review' => 'Tim admisi sedang meninjau data dan dokumen pendaftaran Anda.',
            'revision_required' => 'Admin meminta perbaikan data atau dokumen. Periksa catatan admin di halaman ini.',
            'verified' => 'Data dan dokumen pendaftaran Anda telah diverifikasi.',
            'rejected' => 'Pendaftaran Anda ditolak. Silakan periksa catatan admin untuk detailnya.',
            'accepted' => 'Selamat, pendaftaran Anda dinyatakan diterima.',
        ][$status] ?? 'Status pendaftaran Anda sedang diproses oleh sistem.';
    }

    private function statusBadge(?string $status): string
    {
        return StudentStatusPresenter::badge($status);
    }

    private function statusIcon(?string $status): string
    {
        return [
            'draft' => 'bi-pencil-square',
            'in_progress' => 'bi-pencil-square',
            'documents_uploaded' => 'bi-cloud-check',
            'submitted' => 'bi-send-check',
            'under_review' => 'bi-hourglass-split',
            'revision_required' => 'bi-exclamation-triangle',
            'verified' => 'bi-patch-check',
            'rejected' => 'bi-x-circle',
            'accepted' => 'bi-trophy',
        ][$status] ?? 'bi-info-circle';
    }

    private function statusColor(?string $status): string
    {
        return [
            'submitted' => 'bg-secondary',
            'documents_uploaded' => 'bg-secondary',
            'under_review' => 'bg-secondary',
            'revision_required' => 'bg-amber-500',
            'verified' => 'bg-green-500',
            'accepted' => 'bg-green-500',
            'rejected' => 'bg-red-500',
        ][$status] ?? 'bg-primary';
    }

    private function statusTransitionText(?string $from, ?string $to): string
    {
        if (! $from) {
            return 'Status pendaftaran menjadi ' . $this->statusLabel($to) . '.';
        }

        return 'Status berubah dari ' . $this->statusLabel($from) . ' ke ' . $this->statusLabel($to) . '.';
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
}
