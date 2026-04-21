<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'applicants';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function getProdiAttribute(): \stdClass
    {
        $prodi = new \stdClass();
        $prodi->nama_prodi = $this->attributes['program_studi'] ?? 'Teknik Informatika';

        return $prodi;
    }

    public function getGelombangAttribute(): \stdClass
    {
        $gelombang = new \stdClass();
        $gelombang->nama_gelombang = $this->attributes['gelombang'] ?? 'Gelombang 1';

        return $gelombang;
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->full_name ?? 'Calon Mahasiswa';
    }

    public function getProgramStudiAttribute(): string
    {
        return $this->attributes['program_studi'] ?? 'Teknik Informatika';
    }

    public function getAsalSekolahAttribute(): string
    {
        return $this->attributes['asal_sekolah'] ?? 'SMAN 1 Jakarta';
    }
}
