<?php

namespace App\Http\Controllers;

class StatusPendaftaranController extends Controller
{
    public function index()
    {
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
                'href' => route('pdf'),
            ],
        ];

        $timelineSteps = [
            [
                'id' => '01',
                'title' => 'Akun Dibuat',
                'date' => '12 Mei 2024',
                'status' => 'completed',
            ],
            [
                'id' => '02',
                'title' => 'Formulir Selesai',
                'date' => '14 Mei 2024',
                'status' => 'completed',
            ],
            [
                'id' => '03',
                'title' => 'Verifikasi Berkas',
                'date' => 'Sedang Berlangsung',
                'status' => 'current',
                'subtitle' => 'Menunggu Antrian',
            ],
            [
                'id' => '04',
                'title' => 'Tes Seleksi',
                'date' => 'Belum Terjadwal',
                'status' => 'upcoming',
            ],
        ];

        $activityLog = [
            [
                'date' => '15 Mei 2024, 09:42',
                'activity' => 'Berkas Diterima',
                'description' => 'Sistem telah menerima unggahan berkas lengkap.',
                'color' => 'bg-secondary',
            ],
            [
                'date' => '14 Mei 2024, 16:20',
                'activity' => 'Finalisasi Data',
                'description' => 'Peserta melakukan konfirmasi akhir formulir.',
                'color' => 'bg-green-500',
            ],
            [
                'date' => '12 Mei 2024, 11:05',
                'activity' => 'Registrasi Akun',
                'description' => 'Akun portal PMB berhasil diaktifkan.',
                'color' => 'bg-green-500',
            ],
        ];

        $user = [
            'name' => 'Budi Santoso',
            'regNo' => '202409821',
            'avatar' => asset('images/avatar.png'),
        ];

        return view('mahasiswa.status-pendaftaran', compact('sidebarLinks', 'timelineSteps', 'activityLog', 'user'));
    }
}
