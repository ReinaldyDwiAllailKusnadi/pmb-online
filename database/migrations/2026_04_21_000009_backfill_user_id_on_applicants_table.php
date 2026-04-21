<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('applicants')
            ->join('users', 'applicants.email', '=', 'users.email')
            ->whereNull('applicants.user_id')
            ->update(['applicants.user_id' => DB::raw('users.id')]);
    }

    public function down(): void
    {
        DB::table('applicants')->update(['user_id' => null]);
    }
};
