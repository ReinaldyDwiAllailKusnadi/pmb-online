<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pendaftar' => 3842,
            'terverifikasi' => 2156,
            'total_deposit' => 'Rp 1.42M',
            'menunggu_berkas' => 428,
            'pendaftar_trend' => '+12.5%',
            'terverifikasi_trend' => '+8.2%',
            'deposit_trend' => 'Tetap',
            'menunggu_trend' => '-2.4%',
            'pendaftar_footer' => 'Terakhir update 5 menit lalu',
            'terverifikasi_footer' => 'Konversi: 56.1%',
            'deposit_footer' => '1,890 Transaksi Sukses',
            'menunggu_footer' => 'Rata-rata 48 jam',
        ];

        $barData = [
            ['name' => 'JAN', 'value' => 1200],
            ['name' => 'FEB', 'value' => 2100],
            ['name' => 'MAR', 'value' => 3200],
            ['name' => 'APR', 'value' => 3842, 'isCurrent' => true],
            ['name' => 'MEI', 'value' => 1500, 'isFuture' => true],
            ['name' => 'JUN', 'value' => 800, 'isFuture' => true],
        ];

        $pieData = [
            ['name' => 'Teknik Informatika', 'value' => 45, 'color' => '#022448'],
            ['name' => 'Manajemen', 'value' => 25, 'color' => '#F0A500'],
            ['name' => 'Psikologi', 'value' => 15, 'color' => '#805600'],
            ['name' => 'Lainnya', 'value' => 15, 'color' => '#f1f5f9'],
        ];

        $schools = [
            ['id' => '01', 'name' => 'SMAN 1 Kota Metropolitan', 'location' => 'Jawa Barat, Indonesia', 'count' => 342],
            ['id' => '02', 'name' => 'SMK Informatika Unggul', 'location' => 'Jakarta Selatan, DKI Jakarta', 'count' => 281],
            ['id' => '03', 'name' => 'MA Negeri 2 Pusat', 'location' => 'Bandung, Jawa Barat', 'count' => 195],
            ['id' => '04', 'name' => 'SMA Bintang Nusantara', 'location' => 'Surabaya, Jawa Timur', 'count' => 142],
        ];

        return view('admin.laporan', compact('stats', 'barData', 'pieData', 'schools'));
    }

    public function exportPdf()
    {
        return back()->with('success', 'Export PDF belum tersedia.');
    }

    public function exportExcel()
    {
        return back()->with('success', 'Export Excel belum tersedia.');
    }

    public function sendEmail()
    {
        return back()->with('success', 'Pengiriman email laporan belum tersedia.');
    }
}
