<?php

namespace App\Support;

class StudentStatusPresenter
{
    public static function label(?string $status): string
    {
        return [
            'draft' => 'Draft',
            'in_progress' => 'Sedang Dilengkapi',
            'documents_uploaded' => 'Dokumen Terunggah',
            'submitted' => 'Menunggu Review Admin',
            'terkirim' => 'Menunggu Review Admin',
            'under_review' => 'Menunggu Verifikasi',
            'revision_required' => 'Perlu Revisi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'accepted' => 'Diterima',
        ][$status] ?? ucfirst((string) $status);
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
