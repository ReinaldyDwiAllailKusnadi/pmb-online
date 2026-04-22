<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\GelombangPendaftaran;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Services\PendaftaranProgressService;
use App\Services\PendaftaranStatusService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegistrationController extends Controller
{
    private const DOCUMENT_DISK = 'local';

    private const DOCUMENT_COLUMNS = [
        'photo' => 'photo_path',
        'id_card' => 'id_card_path',
        'family_card' => 'family_card_path',
        'diploma' => 'diploma_path',
        'transcript' => 'transcript_path',
    ];

    private const SUPPORTING_DOCUMENT_COLUMNS = [
        'id_card' => 'id_card_path',
        'family_card' => 'family_card_path',
        'diploma' => 'diploma_path',
        'transcript' => 'transcript_path',
    ];

    public function login(Request $request)
    {
        if ($request->user()) {
            if (! $request->user()->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Akun Anda sedang nonaktif. Hubungi admin PMB untuk mengaktifkan kembali akses.']);
            }

            return $this->redirectAfterLogin($request->user(), $request);
        }

        return view('pages.login');
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = $request->user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Akun Anda sedang nonaktif. Hubungi admin PMB untuk mengaktifkan kembali akses.'])
                    ->onlyInput('email');
            }

            $user->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();

            return $this->redirectAfterLogin($user, $request);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'CALON MAHASISWA',
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard(Request $request)
    {
        $applicant = $this->getApplicant($request);
        $progress = app(PendaftaranProgressService::class)->calculate($applicant);

        return view('pages.dashboard', compact('applicant', 'progress'));
    }

    public function formStep1(Request $request)
    {
        $applicant = $this->getApplicant($request);
        $isReadonly = $this->isReadonly($applicant);
        $regions = config('indonesia_regions', []);
        $provinces = array_keys($regions);
        $programStudi = ProgramStudi::where('is_active', true)->orderBy('nama')->get();
        $gelombangPendaftaran = GelombangPendaftaran::where('is_active', true)
            ->orderBy('tanggal_mulai')
            ->orderBy('nama')
            ->get();

        return view('pages.form-step1', compact('applicant', 'isReadonly', 'regions', 'provinces', 'programStudi', 'gelombangPendaftaran'));
    }

    public function formStep1Store(Request $request)
    {
        $applicant = $this->getApplicant($request);
        $this->assertStudentCanEdit($applicant);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'photo' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'address' => ['nullable', 'string'],
            'current_address' => ['nullable', 'string'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    $province = (string) $request->input('province');
                    $cities = config("indonesia_regions.{$province}", []);

                    if (! in_array($value, $cities, true)) {
                        $fail('Kabupaten / Kota harus sesuai dengan provinsi yang dipilih.');
                    }
                },
            ],
            'province' => ['required', 'string', 'max:255', Rule::in(array_keys(config('indonesia_regions', [])))],
            'home_phone' => ['nullable', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'phone' => ['required', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'citizen' => ['nullable', 'string', 'max:50'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_day' => ['nullable', 'string', 'max:10'],
            'birth_month' => ['nullable', 'string', 'max:20'],
            'birth_year' => ['nullable', 'string', 'max:10'],
            'gender' => ['nullable', 'string', 'max:50'],
            'marital' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'program_studi_id' => ['required', 'exists:program_studi,id'],
            'gelombang_pendaftaran_id' => ['required', 'exists:gelombang_pendaftaran,id'],
        ]);

        $updates = [
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'address' => $validated['address'] ?? null,
            'current_address' => $validated['current_address'] ?? null,
            'district' => $validated['district'] ?? null,
            'city' => $validated['city'] ?? null,
            'province' => $validated['province'] ?? null,
            'home_phone' => $validated['home_phone'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'citizen' => $validated['citizen'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_day' => $validated['birth_day'] ?? null,
            'birth_month' => $validated['birth_month'] ?? null,
            'birth_year' => $validated['birth_year'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'marital' => $validated['marital'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'program_studi_id' => $validated['program_studi_id'],
            'gelombang_pendaftaran_id' => $validated['gelombang_pendaftaran_id'],
        ];

        $oldPhotoPath = $applicant->photo_path;
        $newPhotoPath = null;

        if ($request->hasFile('photo')) {
            $newPhotoPath = $request->file('photo')->store('applicants/' . $applicant->id, self::DOCUMENT_DISK);
            $updates['photo_path'] = $newPhotoPath;
        }

        try {
            $this->saveEditableProgress($request, $applicant, $updates);
        } catch (Throwable $exception) {
            $this->deleteDocument($newPhotoPath);

            throw $exception;
        }

        $applicant->refresh();

        if ($newPhotoPath && $applicant->photo_path === $newPhotoPath) {
            $this->deleteReplacedFiles(['photo_path' => $oldPhotoPath], ['photo_path' => $applicant->photo_path]);
        } else {
            $this->deleteDocument($newPhotoPath);
        }

        return redirect()
            ->route('form.step2')
            ->with('draft_saved', 'Data pribadi berhasil disimpan.');
    }

    public function formStep2(Request $request)
    {
        $applicant = $this->getApplicant($request);
        $isReadonly = $this->isReadonly($applicant);

        return view('pages.form-step2', compact('applicant', 'isReadonly'));
    }

    public function formStep3(Request $request)
    {
        $applicant = $this->getApplicant($request);

        $isReadonly = $this->isReadonly($applicant);

        if (! $isReadonly) {
            if ($redirect = $this->redirectIfDocumentsIncomplete($applicant)) {
                return $redirect;
            }
        }

        return view('pages.form-step3', compact('applicant', 'isReadonly'));
    }

    public function formStep2Store(Request $request)
    {
        $applicant = $this->getApplicant($request);
        $this->assertStudentCanEdit($applicant);

        $request->validate([
            'id_card' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:4096',
            ],
            'family_card' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:4096',
            ],
            'diploma' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:4096',
            ],
            'transcript' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:4096',
            ],
        ]);

        $paths = [];
        $oldPaths = [
            'id_card_path' => $applicant->id_card_path,
            'family_card_path' => $applicant->family_card_path,
            'diploma_path' => $applicant->diploma_path,
            'transcript_path' => $applicant->transcript_path,
        ];
        $storagePath = 'applicants/' . $applicant->id;

        foreach (array_keys(self::SUPPORTING_DOCUMENT_COLUMNS) as $field) {
            if ($request->hasFile($field)) {
                $paths[$field] = $request->file($field)->store($storagePath, self::DOCUMENT_DISK);
            }
        }

        if ($paths === [] && ! $this->supportingDocumentsComplete($applicant)) {
            throw ValidationException::withMessages([
                'documents' => 'Pilih minimal satu dokumen untuk diunggah.',
            ]);
        }

        $updates = [
            'id_card_path' => $paths['id_card'] ?? $applicant->id_card_path,
            'family_card_path' => $paths['family_card'] ?? $applicant->family_card_path,
            'diploma_path' => $paths['diploma'] ?? $applicant->diploma_path,
            'transcript_path' => $paths['transcript'] ?? $applicant->transcript_path,
        ];

        try {
            $this->saveEditableProgress($request, $applicant, $updates);
        } catch (Throwable $exception) {
            $this->deleteDocuments(array_values($paths));

            throw $exception;
        }

        $applicant->refresh();
        $this->deleteReplacedFiles($oldPaths, [
            'id_card_path' => $applicant->id_card_path,
            'family_card_path' => $applicant->family_card_path,
            'diploma_path' => $applicant->diploma_path,
            'transcript_path' => $applicant->transcript_path,
        ]);
        $this->deleteUnreferencedUploads($paths, $applicant);

        $message = $this->applicantDocumentsComplete($applicant)
            ? 'Semua dokumen berhasil disimpan. Klik Lanjut ke Konfirmasi untuk meninjau data.'
            : 'Dokumen berhasil disimpan. Lengkapi dokumen lain sebelum lanjut ke konfirmasi.';

        return redirect()
            ->route('form.step2')
            ->with('success', $message);
    }

    public function status(Request $request)
    {
        return redirect()->route('status.pendaftaran');
    }

    public function pdf(Request $request)
    {
        return redirect()->route('mahasiswa.unduh-bukti');
    }

    private function redirectIfDocumentsIncomplete(Pendaftaran $applicant)
    {
        if (! $this->documentExists($applicant->photo_path)) {
            return redirect()
                ->route('form.step1')
                ->withErrors(['photo' => 'Unggah pas foto pada langkah Data Pribadi sebelum melanjutkan.']);
        }

        $missing = collect(self::SUPPORTING_DOCUMENT_COLUMNS)
            ->contains(fn (string $column) => ! $this->documentExists($applicant->{$column}));

        if ($missing) {
            return redirect()
                ->route('form.step2')
                ->withErrors(['documents' => 'Lengkapi seluruh dokumen sebelum melanjutkan.']);
        }

        return null;
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

    private function saveEditableProgress(Request $request, Pendaftaran $applicant, array $updates): void
    {
        $this->assertStudentCanEdit($applicant);

        if ($applicant->status === 'draft') {
            app(PendaftaranStatusService::class)->transition(
                pendaftaran: $applicant,
                statusTo: 'in_progress',
                actor: $request->user(),
                note: 'Calon mahasiswa mulai melengkapi pendaftaran.',
                updates: $updates
            );

            return;
        }

        if (in_array($applicant->status, ['in_progress', 'revision_required'], true)) {
            if ($this->documentsComplete($updates, $applicant)) {
                app(PendaftaranStatusService::class)->transition(
                    pendaftaran: $applicant,
                    statusTo: 'documents_uploaded',
                    actor: $request->user(),
                    note: 'Calon mahasiswa telah mengunggah seluruh dokumen wajib.',
                    updates: $updates
                );

                return;
            }

            $applicant->update($updates);

            return;
        }

        if ($applicant->status === 'documents_uploaded') {
            $applicant->update($updates);

            return;
        }

        throw ValidationException::withMessages([
            'status' => 'Data pendaftaran tidak dapat diubah pada status saat ini.',
        ]);
    }

    private function assertStudentCanEdit(Pendaftaran $applicant): void
    {
        if ($this->canEdit($applicant)) {
            return;
        }

        throw ValidationException::withMessages([
            'status' => 'Data pendaftaran tidak dapat diubah pada status saat ini. Perubahan hanya dibuka kembali jika admin meminta revisi.',
        ]);
    }

    private function deleteReplacedFiles(array $oldPaths, array $updates): void
    {
        foreach ($oldPaths as $column => $oldPath) {
            $newPath = $updates[$column] ?? null;

            if (! $oldPath || ! $newPath || $oldPath === $newPath) {
                continue;
            }

            $this->deleteDocument($oldPath);
        }
    }

    private function deleteUnreferencedUploads(array $paths, Pendaftaran $applicant): void
    {
        $columns = [
            'id_card' => 'id_card_path',
            'family_card' => 'family_card_path',
            'diploma' => 'diploma_path',
            'transcript' => 'transcript_path',
        ];

        foreach ($paths as $field => $path) {
            $column = $columns[$field] ?? null;

            if ($column && $applicant->{$column} !== $path) {
                $this->deleteDocument($path);
            }
        }
    }

    private function documentsComplete(array $updates, ?Pendaftaran $applicant = null): bool
    {
        foreach (['photo_path', 'id_card_path', 'family_card_path', 'diploma_path', 'transcript_path'] as $field) {
            if (! $this->documentExists($updates[$field] ?? $applicant?->{$field})) {
                return false;
            }
        }

        return true;
    }

    private function supportingDocumentsComplete(Pendaftaran $applicant): bool
    {
        foreach (self::SUPPORTING_DOCUMENT_COLUMNS as $column) {
            if (! $this->documentExists($applicant->{$column})) {
                return false;
            }
        }

        return true;
    }

    private function applicantDocumentsComplete(Pendaftaran $applicant): bool
    {
        return $this->documentsComplete([
            'photo_path' => $applicant->photo_path,
            'id_card_path' => $applicant->id_card_path,
            'family_card_path' => $applicant->family_card_path,
            'diploma_path' => $applicant->diploma_path,
            'transcript_path' => $applicant->transcript_path,
        ]);
    }

    private function canEdit(Pendaftaran $applicant): bool
    {
        return in_array($applicant->status, ['draft', 'in_progress', 'documents_uploaded', 'revision_required'], true);
    }

    private function isReadonly(Pendaftaran $applicant): bool
    {
        return ! $this->canEdit($applicant);
    }

    private function documentExists(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        return $this->documentDisk($path) !== null;
    }

    private function documentDisk(?string $path): ?string
    {
        foreach (['local', 'public'] as $disk) {
            if ($path && Storage::disk($disk)->exists($path)) {
                return $disk;
            }
        }

        return null;
    }

    private function deleteDocuments(array $paths): void
    {
        foreach ($paths as $path) {
            $this->deleteDocument($path);
        }
    }

    private function deleteDocument(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        foreach (['local', 'public'] as $disk) {
            Storage::disk($disk)->delete($path);
        }
    }

    private function redirectAfterLogin(User $user, Request $request)
    {
        return match ($this->normalizedRole($user->role)) {
            'admin', 'system-admin', 'super-admin', 'administrator' => redirect()->route('admin.dashboard'),
            'calon-mahasiswa', 'mahasiswa', 'student', 'applicant' => redirect()->route('dashboard'),
            default => $this->redirectUnsupportedRole($request),
        };
    }

    private function redirectUnsupportedRole(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors(['email' => 'Role akun belum memiliki akses ke portal PMB.']);
    }

    private function normalizedRole(?string $role): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower((string) $role)), '-');
    }
}
