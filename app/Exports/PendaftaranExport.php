<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranExport implements FromCollection, WithHeadings
{
    public function __construct(private Collection $pendaftaran)
    {
    }

    public function collection(): Collection
    {
        return $this->pendaftaran->map(function (Pendaftaran $row) {
            return [
                'No Pendaftaran' => $row->no_pendaftaran ?? ('#PMB' . str_pad($row->id, 4, '0', STR_PAD_LEFT)),
                'Nama' => $row->user?->nama_lengkap ?? $row->nama_lengkap,
                'Email' => $row->user?->email ?? $row->email,
                'Program Studi' => $row->prodi->nama_prodi,
                'Gelombang' => $row->gelombang->nama_gelombang,
                'Status' => $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['No Pendaftaran', 'Nama', 'Email', 'Program Studi', 'Gelombang', 'Status'];
    }
}
