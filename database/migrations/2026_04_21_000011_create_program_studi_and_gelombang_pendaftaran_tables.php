<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('jenjang')->nullable();
            $table->string('fakultas')->nullable();
            $table->unsignedInteger('kuota')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gelombang_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tahun_akademik');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('program_studi')->insert([
            [
                'kode' => 'TI-S1',
                'nama' => 'Teknik Informatika',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Teknologi Informasi',
                'kuota' => 120,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SI-S1',
                'nama' => 'Sistem Informasi',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Teknologi Informasi',
                'kuota' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'MNJ-S1',
                'nama' => 'Manajemen',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Ekonomi dan Bisnis',
                'kuota' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('gelombang_pendaftaran')->insert([
            [
                'nama' => 'Gelombang 1',
                'tahun_akademik' => '2026/2027',
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-03-31',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gelombang 2',
                'tahun_akademik' => '2026/2027',
                'tanggal_mulai' => '2026-04-01',
                'tanggal_selesai' => '2026-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gelombang 3',
                'tahun_akademik' => '2026/2027',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-09-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Schema::table('applicants', function (Blueprint $table) {
            $table->foreign('program_studi_id')->references('id')->on('program_studi')->nullOnDelete();
            $table->foreign('gelombang_pendaftaran_id')->references('id')->on('gelombang_pendaftaran')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->dropForeign(['gelombang_pendaftaran_id']);
        });

        Schema::dropIfExists('gelombang_pendaftaran');
        Schema::dropIfExists('program_studi');
    }
};
