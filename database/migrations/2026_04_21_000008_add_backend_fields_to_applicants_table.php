<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->string('nomor_pendaftaran')->nullable()->unique()->after('email');
            $table->unsignedBigInteger('program_studi_id')->nullable()->after('nomor_pendaftaran');
            $table->unsignedBigInteger('gelombang_pendaftaran_id')->nullable()->after('program_studi_id');
            $table->text('catatan_admin')->nullable()->after('status');
            $table->timestamp('submitted_at')->nullable()->after('catatan_admin');
            $table->timestamp('verified_at')->nullable()->after('submitted_at');
            $table->foreignId('verified_by')
                ->nullable()
                ->after('verified_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['verified_by']);
            $table->dropUnique(['nomor_pendaftaran']);
            $table->dropColumn([
                'user_id',
                'nomor_pendaftaran',
                'program_studi_id',
                'gelombang_pendaftaran_id',
                'catatan_admin',
                'submitted_at',
                'verified_at',
                'verified_by',
            ]);
        });
    }
};
