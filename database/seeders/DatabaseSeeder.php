<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->delete();

        $password = Hash::make('password');

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@university.ac.id',
            'password' => $password,
            'role' => 'SYSTEM ADMIN',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(2),
            'last_login_ip' => '182.253.x.x',
        ]);

        User::create([
            'name' => 'Ahmad Subarkah',
            'email' => 'ahmad.sub@univ.ac.id',
            'password' => $password,
            'role' => 'SYSTEM ADMIN',
            'is_active' => true,
            'last_login_at' => now()->subMinutes(2),
            'last_login_ip' => '182.253.x.x',
        ]);

        User::create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti.rahma@student.ac.id',
            'password' => $password,
            'role' => 'CALON MAHASISWA',
            'is_active' => true,
            'last_login_at' => now()->subHours(3),
            'last_login_ip' => '114.124.x.x',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.san@univ.ac.id',
            'password' => $password,
            'role' => 'SEKRETARIAT',
            'is_active' => false,
            'last_login_at' => now()->subDays(5),
            'last_login_ip' => '103.10.x.x',
        ]);

        User::create([
            'name' => 'Larasati Putri',
            'email' => 'larasati.putri@gmail.com',
            'password' => $password,
            'role' => 'CALON MAHASISWA',
            'is_active' => true,
            'last_login_at' => now()->subDay()->setTime(14, 20),
            'last_login_ip' => '36.72.x.x',
        ]);
    }
}
