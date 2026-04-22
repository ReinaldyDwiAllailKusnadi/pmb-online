<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataPendaftaranController;
use App\Http\Controllers\Admin\KelolaUserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\KonfirmasiPendaftaranController;
use App\Http\Controllers\LegacyRouteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StatusPendaftaranController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\UnduhBuktiController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('public.home'))->name('home');
Route::get('/program-studi', fn () => view('public.program-studi'))->name('program-studi.index');
Route::get('/program-studi/{slug}', fn (string $slug) => view('public.program-studi-detail', compact('slug')))->name('program-studi.show');
Route::get('/informasi', fn () => view('public.informasi'))->name('informasi.index');
Route::get('/kontak', fn () => view('public.kontak'))->name('kontak');
Route::get('/login', [RegistrationController::class, 'login'])->name('login');
Route::post('/login', [RegistrationController::class, 'loginStore'])->name('login.store');
Route::get('/register', [RegistrationController::class, 'register'])->name('register');
Route::post('/register', [RegistrationController::class, 'registerStore'])->name('register.store');

Route::post('/logout', [RegistrationController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export-pdf');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export-excel');
        Route::post('/laporan/kirim-email', [LaporanController::class, 'sendEmail'])->name('admin.laporan.kirim-email');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('admin.pengaturan.profil.update');
        Route::get('/data-pendaftaran', [DataPendaftaranController::class, 'index'])->name('admin.data-pendaftaran');
        Route::get('/data-pendaftaran/export/excel', [DataPendaftaranController::class, 'exportExcel'])->name('admin.data-pendaftaran.export.excel');
        Route::get('/data-pendaftaran/export/pdf', [DataPendaftaranController::class, 'exportPdf'])->name('admin.data-pendaftaran.export.pdf');
        Route::get('/data-pendaftaran/{pendaftaran}/dokumen/{document}', [DataPendaftaranController::class, 'showDocument'])->name('admin.data-pendaftaran.dokumen.show');
        Route::get('/data-pendaftaran/{pendaftaran}', [DataPendaftaranController::class, 'show'])->name('admin.data-pendaftaran.show');
        Route::patch('/data-pendaftaran/{pendaftaran}/mark-under-review', [DataPendaftaranController::class, 'markUnderReview'])->name('admin.data-pendaftaran.mark-under-review');
        Route::patch('/data-pendaftaran/{pendaftaran}/verify', [DataPendaftaranController::class, 'verify'])->name('admin.data-pendaftaran.verify');
        Route::patch('/data-pendaftaran/{pendaftaran}/reject', [DataPendaftaranController::class, 'reject'])->name('admin.data-pendaftaran.reject');
        Route::patch('/data-pendaftaran/{pendaftaran}/request-revision', [DataPendaftaranController::class, 'requestRevision'])->name('admin.data-pendaftaran.request-revision');
        Route::get('/kelola-user', [KelolaUserController::class, 'index'])->name('admin.kelola-user');
        Route::post('/kelola-user', [KelolaUserController::class, 'store'])->name('admin.kelola-user.store');
        Route::patch('/kelola-user/{user}/toggle', [KelolaUserController::class, 'toggleStatus'])->name('admin.kelola-user.toggle');
        Route::delete('/kelola-user/{user}', [KelolaUserController::class, 'destroy'])->name('admin.kelola-user.destroy');
    });

Route::middleware(['auth', 'active', 'role:calon-mahasiswa'])
    ->prefix('mahasiswa')
    ->group(function () {
        Route::get('/dashboard', [RegistrationController::class, 'dashboard'])->name('dashboard');
        Route::get('/form/step-1', [RegistrationController::class, 'formStep1'])->name('form.step1');
        Route::post('/form/step-1', [RegistrationController::class, 'formStep1Store'])->name('form.step1.store');
        Route::get('/form/step-2', [RegistrationController::class, 'formStep2'])->name('form.step2');
        Route::post('/form/step-2', [RegistrationController::class, 'formStep2Store'])->name('form.step2.store');
        Route::get('/form/step-3', [RegistrationController::class, 'formStep3'])->name('form.step3');
        Route::post('/form/step-3', [KonfirmasiPendaftaranController::class, 'kirim'])->name('form.step3.store');
        Route::get('/formulir/konfirmasi', [KonfirmasiPendaftaranController::class, 'index'])->name('mahasiswa.konfirmasi');
        Route::post('/formulir/konfirmasi/kirim', [KonfirmasiPendaftaranController::class, 'kirim'])->name('mahasiswa.konfirmasi.kirim');
        Route::get('/status-pendaftaran', [StatusPendaftaranController::class, 'index'])->name('status.pendaftaran');
        Route::patch('/notifikasi/{notification}/read', [NotificationController::class, 'markAsRead'])->name('mahasiswa.notifikasi.read');
        Route::patch('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('mahasiswa.notifikasi.read-all');
        Route::get('/dokumen/{document}', [StudentDocumentController::class, 'show'])->name('mahasiswa.dokumen.show');
        Route::get('/unduh-bukti', [UnduhBuktiController::class, 'index'])->name('mahasiswa.unduh-bukti');
        Route::get('/unduh-bukti/pdf', [UnduhBuktiController::class, 'downloadPdf'])->name('mahasiswa.unduh-bukti-pdf');
    });

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [LegacyRouteController::class, 'dashboard']);
    Route::get('/form/step-1', [LegacyRouteController::class, 'formStep1']);
    Route::get('/form/step-2', [LegacyRouteController::class, 'formStep2']);
    Route::get('/form/step-3', [LegacyRouteController::class, 'formStep3']);
    Route::get('/formulir/konfirmasi', [LegacyRouteController::class, 'konfirmasi']);
    Route::get('/status', [LegacyRouteController::class, 'status']);
    Route::get('/status-pendaftaran', [LegacyRouteController::class, 'status']);
    Route::get('/pdf', [LegacyRouteController::class, 'bukti']);
    Route::get('/unduh-bukti', [LegacyRouteController::class, 'bukti']);
    Route::get('/unduh-bukti/pdf', [LegacyRouteController::class, 'buktiPdf']);
});
