<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('class')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);
        return view('mahasiswa.certificates.index', compact('certificates'));
    }

    public function download(Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) abort(403);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.template', compact('certificate'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
    }
}
