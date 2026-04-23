<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $programs = [
        ['kode' => 'TI', 'nama' => 'Teknik Informatika', 'fakultas' => 'Fakultas Ilmu Komputer', 'kuota' => 120],
        ['kode' => 'KD', 'nama' => 'Kedokteran', 'fakultas' => 'Fakultas Kedokteran', 'kuota' => 80],
        ['kode' => 'MNJ', 'nama' => 'Manajemen', 'fakultas' => 'Fakultas Ekonomi dan Bisnis', 'kuota' => 100],
        ['kode' => 'ARS', 'nama' => 'Arsitektur', 'fakultas' => 'Fakultas Teknik', 'kuota' => 80],
        ['kode' => 'PSI', 'nama' => 'Psikologi', 'fakultas' => 'Fakultas Psikologi', 'kuota' => 90],
        ['kode' => 'IKOM', 'nama' => 'Ilmu Komunikasi', 'fakultas' => 'Fakultas Ilmu Sosial dan Komunikasi', 'kuota' => 100],
    ];

    public function up(): void
    {
        $officialNames = collect($this->programs)->pluck('nama')->all();

        DB::table('program_studi')
            ->whereNotIn('nama', $officialNames)
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);

        foreach ($this->programs as $program) {
            $existing = DB::table('program_studi')->where('nama', $program['nama'])->first();

            $payload = [
                'kode' => $program['kode'],
                'nama' => $program['nama'],
                'jenjang' => null,
                'fakultas' => $program['fakultas'],
                'kuota' => $program['kuota'],
                'is_active' => true,
                'updated_at' => now(),
            ];

            if ($existing) {
                DB::table('program_studi')->where('id', $existing->id)->update($payload);
            } else {
                DB::table('program_studi')->insert(array_merge($payload, [
                    'created_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('program_studi')
            ->whereIn('nama', collect($this->programs)->pluck('nama')->all())
            ->update([
                'is_active' => true,
                'updated_at' => now(),
            ]);
    }
};
