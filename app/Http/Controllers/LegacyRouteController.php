<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegacyRouteController extends Controller
{
    public function dashboard(Request $request)
    {
        return $this->redirectByRole($request, 'dashboard');
    }

    public function formStep1(Request $request)
    {
        return $this->redirectByRole($request, 'form.step1');
    }

    public function formStep2(Request $request)
    {
        return $this->redirectByRole($request, 'form.step2');
    }

    public function formStep3(Request $request)
    {
        return $this->redirectByRole($request, 'form.step3');
    }

    public function konfirmasi(Request $request)
    {
        return $this->redirectByRole($request, 'form.step3');
    }

    public function status(Request $request)
    {
        return $this->redirectByRole($request, 'status.pendaftaran');
    }

    public function bukti(Request $request)
    {
        return $this->redirectByRole($request, 'mahasiswa.unduh-bukti');
    }

    public function buktiPdf(Request $request)
    {
        return $this->redirectByRole($request, 'mahasiswa.unduh-bukti-pdf');
    }

    private function redirectByRole(Request $request, string $studentRoute)
    {
        $role = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower((string) $request->user()->role)), '-');

        if (in_array($role, ['admin', 'system-admin', 'super-admin', 'administrator'], true)) {
            return redirect()->route('admin.dashboard');
        }

        if (in_array($role, ['calon-mahasiswa', 'mahasiswa', 'student', 'applicant'], true)) {
            return redirect()->route($studentRoute);
        }

        abort(403);
    }
}
