<?php

namespace App\Support;

class StudentStatusPresenter
{
    public static function labels(): array
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'Sedang Diisi',
            'documents_uploaded' => 'Dokumen Lengkap',
            'submitted' => 'Menunggu Review Admin',
            'terkirim' => 'Menunggu Review Admin',
            'under_review' => 'Sedang Diverifikasi',
            'revision_required' => 'Perlu Revisi',
            'verified' => 'Terverifikasi',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];
    }

    public static function label(?string $status): string
    {
        return self::labels()[$status] ?? ucfirst((string) $status);
    }

    public static function badge(?string $status): string
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'In Progress',
            'documents_uploaded' => 'Documents',
            'submitted' => 'Review Admin',
            'terkirim' => 'Review Admin',
            'under_review' => 'In Review',
            'revision_required' => 'Revision',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted',
        ][$status] ?? 'Status';
    }
}
