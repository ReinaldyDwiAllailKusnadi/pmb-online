<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelolaUserController extends Controller
{
    private const ROLE_OPTIONS = [
        'SYSTEM ADMIN' => 'System Admin',
        'CALON MAHASISWA' => 'Calon Mahasiswa',
    ];

    private const ADMIN_ROLES = ['SYSTEM ADMIN', 'system admin', 'ADMIN', 'admin', 'SYSTEM ADMINISTRATOR', 'SUPER ADMIN', 'SUPERADMIN'];

    public function index(Request $request)
    {
        $tab = $request->string('tab', 'semua')->toString();

        $query = User::query();

        if ($tab === 'admin') {
            $query->whereIn('role', self::ADMIN_ROLES);
        } elseif ($tab === 'calon-mahasiswa') {
            $query->where('role', 'CALON MAHASISWA');
        }

        if ($request->filled('q')) {
            $search = trim($request->string('q')->toString());

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $totalAktif = User::where('is_active', true)->count();
        $roleStats = [
            'admin' => User::whereIn('role', self::ADMIN_ROLES)->count(),
            'pendaftar' => User::where('role', 'CALON MAHASISWA')->count(),
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

    public function create()
    {
        return view('admin.kelola-user-form', [
            'mode' => 'create',
            'user' => new User(['role' => 'CALON MAHASISWA', 'is_active' => true]),
            'roleOptions' => self::ROLE_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()
            ->route('admin.kelola-user')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.kelola-user-form', [
            'mode' => 'edit',
            'user' => $user,
            'roleOptions' => self::ROLE_OPTIONS,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate($this->rules($user));

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => (bool) $validated['is_active'],
        ]);

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('admin.kelola-user')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        if ($request->user()?->is($user)) {
            return back()->withErrors('Anda tidak dapat menonaktifkan akun yang sedang digunakan.');
        }

        if ($user->is_active && $this->isLastActiveAdmin($user)) {
            return back()->withErrors('Minimal harus ada satu admin aktif di sistem.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', 'Status user berhasil diubah.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()?->is($user)) {
            return back()->withErrors('Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        if ($this->isLastAdmin($user)) {
            return back()->withErrors('Minimal harus ada satu admin di sistem.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(?User $user = null): array
    {
        $emailRule = Rule::unique('users', 'email')->ignore($user?->id);

        if (method_exists($emailRule, 'withoutTrashed')) {
            $emailRule = $emailRule->withoutTrashed();
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', $emailRule],
            'role' => ['required', Rule::in(array_keys(self::ROLE_OPTIONS))],
            'is_active' => ['required', 'boolean'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }

    private function isLastAdmin(User $user): bool
    {
        if (! $this->isAdminRole($user->role)) {
            return false;
        }

        return ! User::whereIn('role', self::ADMIN_ROLES)
            ->where('id', '!=', $user->id)
            ->exists();
    }

    private function isLastActiveAdmin(User $user): bool
    {
        if (! $this->isAdminRole($user->role)) {
            return false;
        }

        return ! User::whereIn('role', self::ADMIN_ROLES)
            ->where('is_active', true)
            ->where('id', '!=', $user->id)
            ->exists();
    }

    private function isAdminRole(?string $role): bool
    {
        return in_array(strtoupper((string) $role), self::ADMIN_ROLES, true);
    }
}


