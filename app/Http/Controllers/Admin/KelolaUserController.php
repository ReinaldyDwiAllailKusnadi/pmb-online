<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaUserController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->string('tab', 'semua');

        $query = User::query();

        if ($tab === 'admin') {
            $query->whereIn('role', ['admin', 'system admin', 'SYSTEM ADMIN']);
        } elseif ($tab === 'calon-mahasiswa') {
            $query->whereIn('role', ['calon mahasiswa', 'CALON MAHASISWA']);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $totalAktif = User::where('is_active', true)->count();
        $roleStats = [
            'admin' => User::whereIn('role', ['admin', 'system admin', 'SYSTEM ADMIN'])->count(),
            'pendaftar' => User::whereIn('role', ['calon mahasiswa', 'CALON MAHASISWA'])->count(),
            'sekretariat' => User::whereIn('role', ['sekretariat', 'SEKRETARIAT'])->count(),
        ];

        $storageUsed = '6.5 GB';
        $storageTotal = '10 GB';
        $storagePercent = 65;
        $trendPersen = '+12%';

        return view('admin.kelola-user', compact(
            'users',
            'totalAktif',
            'roleStats',
            'storageUsed',
            'storageTotal',
            'storagePercent',
            'trendPersen'
        ));
    }

    public function toggleStatus(Request $request, User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', 'Status user berhasil diubah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'max:50'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
