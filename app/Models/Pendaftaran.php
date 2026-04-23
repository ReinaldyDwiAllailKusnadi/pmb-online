<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use SoftDeletes;

    protected $table = 'applicants';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function gelombangPendaftaran(): BelongsTo
    {
        return $this->belongsTo(GelombangPendaftaran::class);
    }

    public function getProdiAttribute(): \stdClass
    {
        $prodi = new \stdClass();
        $programStudi = $this->programStudiModel();
        $prodi->nama_prodi = $programStudi?->displayName();

        return $prodi;
    }

    public function getGelombangAttribute(): \stdClass
    {
        $gelombangPendaftaran = $this->gelombangPendaftaranModel();
        $gelombang = new \stdClass();
        $gelombang->nama_gelombang = $gelombangPendaftaran?->nama;
        $gelombang->tahun_akademik = $gelombangPendaftaran?->tahun_akademik;

        return $gelombang;
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->full_name ?? '';
    }

    public function getProgramStudiAttribute(): ?string
    {
        $programStudi = $this->programStudiModel();

        if (! $programStudi) {
            return null;
        }

        return $programStudi->displayName();
    }

    public function getAsalSekolahAttribute(): ?string
    {
        return $this->attributes['asal_sekolah'] ?? null;
    }

    private function programStudiModel(): ?ProgramStudi
    {
        if ($this->relationLoaded('programStudi')) {
            return $this->getRelation('programStudi');
        }

        return $this->programStudi()->first();
    }

    private function gelombangPendaftaranModel(): ?GelombangPendaftaran
    {
        if ($this->relationLoaded('gelombangPendaftaran')) {
            return $this->getRelation('gelombangPendaftaran');
        }

        return $this->gelombangPendaftaran()->first();
    }
}
