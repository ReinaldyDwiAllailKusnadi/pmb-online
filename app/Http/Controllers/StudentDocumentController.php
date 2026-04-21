<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StudentDocumentController extends Controller
{
    private const DOCUMENT_COLUMNS = [
        'photo' => 'photo_path',
        'id-card' => 'id_card_path',
        'family-card' => 'family_card_path',
        'diploma' => 'diploma_path',
        'transcript' => 'transcript_path',
    ];

    public function show(Request $request, string $document): Response
    {
        abort_unless(array_key_exists($document, self::DOCUMENT_COLUMNS), 404);

        $applicant = Pendaftaran::query()
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $path = $applicant->{self::DOCUMENT_COLUMNS[$document]};

        abort_unless($this->isOwnStoredDocument($path, $applicant), 404);
        $disk = $this->documentDisk($path);

        abort_unless($disk, 404);

        return Storage::disk($disk)->response($path, basename($path), [
            'Content-Type' => Storage::disk($disk)->mimeType($path) ?: 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function isOwnStoredDocument(?string $path, Pendaftaran $applicant): bool
    {
        if (blank($path)) {
            return false;
        }

        return str_starts_with($path, 'applicants/' . $applicant->id . '/');
    }

    private function documentDisk(?string $path): ?string
    {
        foreach (['local', 'public'] as $disk) {
            if ($path && Storage::disk($disk)->exists($path)) {
                return $disk;
            }
        }

        return null;
    }
}
