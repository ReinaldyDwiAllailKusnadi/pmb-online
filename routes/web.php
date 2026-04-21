<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataPendaftaranController;
use App\Http\Controllers\KonfirmasiPendaftaranController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StatusPendaftaranController;
use App\Http\Controllers\UnduhBuktiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'login'])->name('login');
Route::post('/login', [RegistrationController::class, 'loginStore'])->name('login.store');
Route::get('/register', [RegistrationController::class, 'register'])->name('register');
Route::post('/register', [RegistrationController::class, 'registerStore'])->name('register.store');
Route::middleware('auth')->group(function () {
	Route::middleware(['role:admin'])->prefix('admin')->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
		Route::get('/data-pendaftaran', [DataPendaftaranController::class, 'index'])->name('admin.data-pendaftaran');
		Route::get('/data-pendaftaran/export/excel', [DataPendaftaranController::class, 'exportExcel'])->name('admin.data-pendaftaran.export.excel');
		Route::get('/data-pendaftaran/export/pdf', [DataPendaftaranController::class, 'exportPdf'])->name('admin.data-pendaftaran.export.pdf');
	});
	Route::get('/dashboard', [RegistrationController::class, 'dashboard'])->name('dashboard');
	Route::get('/form/step-1', [RegistrationController::class, 'formStep1'])->name('form.step1');
	Route::post('/form/step-1', [RegistrationController::class, 'formStep1Store'])->name('form.step1.store');
	Route::get('/form/step-2', [RegistrationController::class, 'formStep2'])->name('form.step2');
	Route::post('/form/step-2', [RegistrationController::class, 'formStep2Store'])->name('form.step2.store');
	Route::get('/form/step-3', [RegistrationController::class, 'formStep3'])->name('form.step3');
	Route::get('/formulir/konfirmasi', [KonfirmasiPendaftaranController::class, 'index'])->name('mahasiswa.konfirmasi');
	Route::post('/formulir/konfirmasi/kirim', [KonfirmasiPendaftaranController::class, 'kirim'])->name('mahasiswa.konfirmasi.kirim');
	Route::get('/status', [RegistrationController::class, 'status'])->name('status');
	Route::get('/status-pendaftaran', [StatusPendaftaranController::class, 'index'])->name('status.pendaftaran');
	Route::get('/pdf', [RegistrationController::class, 'pdf'])->name('pdf');
	Route::get('/unduh-bukti', [UnduhBuktiController::class, 'index'])->name('mahasiswa.unduh-bukti');
	Route::get('/unduh-bukti/pdf', [UnduhBuktiController::class, 'downloadPdf'])->name('mahasiswa.unduh-bukti-pdf');
	Route::post('/logout', [RegistrationController::class, 'logout'])->name('logout');
});
