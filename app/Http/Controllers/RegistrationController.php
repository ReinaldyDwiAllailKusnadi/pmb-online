<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function login()
    {
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

            return redirect()->route('dashboard');
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

        return view('pages.dashboard', compact('applicant'));
    }

    public function formStep1(Request $request)
    {
        $applicant = $this->getApplicant($request);

        return view('pages.form-step1', compact('applicant'));
    }

    public function formStep1Store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'current_address' => ['nullable', 'string'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'home_phone' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'citizen' => ['nullable', 'string', 'max:50'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_day' => ['nullable', 'string', 'max:10'],
            'birth_month' => ['nullable', 'string', 'max:20'],
            'birth_year' => ['nullable', 'string', 'max:10'],
            'gender' => ['nullable', 'string', 'max:50'],
            'marital' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
        ]);

        $applicant = Applicant::updateOrCreate(
            ['email' => $validated['email']],
            [
                'full_name' => $validated['full_name'],
                'address' => $validated['address'],
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
                'status' => 'in_progress',
            ]
        );

        $request->session()->put('applicant_id', $applicant->id);

        return redirect()->route('form.step2');
    }

    public function formStep2(Request $request)
    {
        $applicant = $this->getApplicant($request);

        return view('pages.form-step2', compact('applicant'));
    }

    public function formStep3(Request $request)
    {
        $applicant = $this->getApplicant($request);

        if ($redirect = $this->redirectIfDocumentsIncomplete($applicant)) {
            return $redirect;
        }

        return view('pages.form-step3', compact('applicant'));
    }

    public function formStep2Store(Request $request)
    {
        $applicant = $this->getApplicant($request);

        $validated = $request->validate([
            'photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_card' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'family_card' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'diploma' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'transcript' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $paths = [];
        $storagePath = 'applicants/' . $applicant->id;

        foreach (['photo', 'id_card', 'family_card', 'diploma', 'transcript'] as $field) {
            $paths[$field] = $request->file($field)->store($storagePath, 'public');
        }

        $applicant->update([
            'photo_path' => $paths['photo'] ?? $applicant->photo_path,
            'id_card_path' => $paths['id_card'] ?? $applicant->id_card_path,
            'family_card_path' => $paths['family_card'] ?? $applicant->family_card_path,
            'diploma_path' => $paths['diploma'] ?? $applicant->diploma_path,
            'transcript_path' => $paths['transcript'] ?? $applicant->transcript_path,
            'status' => 'documents_uploaded',
        ]);

        return redirect()->route('form.step3');
    }

    public function status(Request $request)
    {
        $applicant = $this->getApplicant($request);

        if ($redirect = $this->redirectIfDocumentsIncomplete($applicant)) {
            return $redirect;
        }

        return view('pages.status', compact('applicant'));
    }

    public function pdf(Request $request)
    {
        $applicant = $this->getApplicant($request);

        if ($redirect = $this->redirectIfDocumentsIncomplete($applicant)) {
            return $redirect;
        }

        return view('pages.pdf', compact('applicant'));
    }

    private function redirectIfDocumentsIncomplete(Applicant $applicant)
    {
        $missing = collect([
            $applicant->photo_path,
            $applicant->id_card_path,
            $applicant->family_card_path,
            $applicant->diploma_path,
            $applicant->transcript_path,
        ])->contains(null);

        if ($missing) {
            return redirect()
                ->route('form.step2')
                ->withErrors(['documents' => 'Lengkapi seluruh dokumen sebelum melanjutkan.']);
        }

        return null;
    }

    private function getApplicant(Request $request): Applicant
    {
        $applicantId = $request->session()->get('applicant_id');

        if ($applicantId) {
            $found = Applicant::find($applicantId);
            if ($found) {
                return $found;
            }
        }

        return Applicant::firstOrCreate(
            ['email' => 'budi.santoso@example.com'],
            ['full_name' => 'Budi Santoso', 'address' => 'Jl. Merdeka No. 45, Jakarta Selatan', 'status' => 'draft']
        );
    }
}