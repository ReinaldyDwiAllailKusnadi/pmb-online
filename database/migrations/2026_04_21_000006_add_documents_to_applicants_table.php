<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('religion');
            $table->string('id_card_path')->nullable()->after('photo_path');
            $table->string('family_card_path')->nullable()->after('id_card_path');
            $table->string('diploma_path')->nullable()->after('family_card_path');
            $table->string('transcript_path')->nullable()->after('diploma_path');
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'photo_path',
                'id_card_path',
                'family_card_path',
                'diploma_path',
                'transcript_path',
            ]);
        });
    }
};
