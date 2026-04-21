<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    private const PROFILE_PATH = 'institution-profile.json';

    public function index()
    {
        $institution = $this->institutionProfile();
        $user = auth()->user();

        $admin = [
            'name' => $user->name ?? 'Direktorat TIK',
            'role' => strtoupper($user->role ?? 'SUPERADMIN'),
            'avatar' => $user?->foto
                ? asset('storage/'.$user->foto)
                : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'Admin Utama').'&background=1E3A5F&color=fff&bold=true',
        ];

        $settingCategories = [
            'utama' => [
                ['key' => 'profil-institusi', 'label' => 'Profil Institusi', 'icon' => 'bi-bank2', 'active' => true],
                ['key' => 'periode-pendaftaran', 'label' => 'Periode Pendaftaran', 'icon' => 'bi-calendar-event-fill'],
                ['key' => 'skema-pembayaran', 'label' => 'Skema Pembayaran', 'icon' => 'bi-credit-card-2-front-fill'],
                ['key' => 'keamanan-audit', 'label' => 'Keamanan & Audit', 'icon' => 'bi-shield-check'],
            ],
            'integrasi' => [
                ['key' => 'api-webhooks', 'label' => 'API Key & Webhooks', 'icon' => 'bi-code-slash'],
            ],
        ];

        return view('admin.pengaturan', compact('institution', 'admin', 'settingCategories'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'nama_institusi' => ['required', 'string', 'max:255'],
            'kode_dikti' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:50'],
            'website' => ['required', 'url', 'max:255'],
            'logo' => ['nullable', 'file', 'mimes:png,svg,jpg,jpeg', 'max:2048'],
        ]);

        $institution = $this->institutionProfile();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('institution', 'public');
            $validated['logo'] = asset('storage/'.$path);
        } else {
            $validated['logo'] = $institution['logo'];
        }

        $profile = [
            'nama' => $validated['nama_institusi'],
            'kode_dikti' => $validated['kode_dikti'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'website' => $validated['website'],
            'logo' => $validated['logo'],
        ];

        Storage::disk('local')->put(self::PROFILE_PATH, json_encode($profile, JSON_PRETTY_PRINT));

        return back()->with('success', 'Profil institusi berhasil diperbarui.');
    }

    private function institutionProfile(): array
    {
        $defaults = [
            'nama' => 'Universitas Nusantara Cendekia',
            'kode_dikti' => '001032',
            'alamat' => 'Jl. Pendidikan No. 45, Kompleks Akademik Utama, Jakarta Selatan, DKI Jakarta 12340',
            'email' => 'admission@unc.ac.id',
            'telepon' => '+62 21 5550 9988',
            'website' => 'https://www.unc.ac.id',
            'logo' => null,
        ];

        if (! Storage::disk('local')->exists(self::PROFILE_PATH)) {
            return $defaults;
        }

        $stored = json_decode(Storage::disk('local')->get(self::PROFILE_PATH), true);

        return array_merge($defaults, is_array($stored) ? $stored : []);
    }
}
