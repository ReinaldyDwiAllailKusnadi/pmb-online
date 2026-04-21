<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if (! $this->roleMatches((string) $user->role, $role)) {
            abort(403);
        }

        return $next($request);
    }

    private function roleMatches(string $actualRole, string $expectedRole): bool
    {
        $actual = $this->normalize($actualRole);
        $expected = $this->normalize($expectedRole);

        $allowedRoles = [
            'admin' => ['admin', 'system-admin', 'super-admin', 'administrator'],
            'calon-mahasiswa' => ['calon-mahasiswa', 'mahasiswa', 'student', 'applicant'],
        ];

        return in_array($actual, $allowedRoles[$expected] ?? [$expected], true);
    }

    private function normalize(string $role): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($role)), '-');
    }
}
