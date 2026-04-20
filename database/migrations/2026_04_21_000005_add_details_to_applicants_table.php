<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->text('current_address')->nullable()->after('address');
            $table->string('district')->nullable()->after('current_address');
            $table->string('city')->nullable()->after('district');
            $table->string('province')->nullable()->after('city');
            $table->string('home_phone')->nullable()->after('province');
            $table->string('phone')->nullable()->after('home_phone');
            $table->string('citizen')->nullable()->after('phone');
            $table->string('birth_place')->nullable()->after('citizen');
            $table->string('birth_day')->nullable()->after('birth_place');
            $table->string('birth_month')->nullable()->after('birth_day');
            $table->string('birth_year')->nullable()->after('birth_month');
            $table->string('gender')->nullable()->after('birth_year');
            $table->string('marital')->nullable()->after('gender');
            $table->string('religion')->nullable()->after('marital');
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'current_address',
                'district',
                'city',
                'province',
                'home_phone',
                'phone',
                'citizen',
                'birth_place',
                'birth_day',
                'birth_month',
                'birth_year',
                'gender',
                'marital',
                'religion',
            ]);
        });
    }
};
