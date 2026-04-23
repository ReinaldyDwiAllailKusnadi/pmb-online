<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    /**
     * @return array<int, string>
     */
    public static function officialNames(): array
    {
        return config('program_studi', [
            'Teknik Informatika',
            'Kedokteran',
            'Manajemen',
            'Arsitektur',
            'Psikologi',
            'Ilmu Komunikasi',
        ]);
    }

    public function scopeOfficial($query)
    {
        return $query->whereIn('nama', self::officialNames());
    }

    public function scopeOfficialActive($query)
    {
        return $query->official()->where('is_active', true);
    }

    public static function officialActiveOptions()
    {
        $order = array_flip(self::officialNames());

        return self::officialActive()
            ->get()
            ->sortBy(fn (ProgramStudi $program) => $order[$program->nama] ?? 999)
            ->values();
    }

    public function displayName(): string
    {
        return $this->nama;
    }
}
