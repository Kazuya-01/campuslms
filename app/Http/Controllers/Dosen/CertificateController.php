<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\LMSClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $classes = LMSClass::where('dosen_id', auth()->id())->with('students')->get();
        $certificates = Certificate::with('user', 'class')
            ->whereIn('class_id', $classes->pluck('id'))
            ->latest()
            ->paginate(20);
        return view('dosen.certificates.index', compact('classes', 'certificates'));
    }

    public function create()
    {
        $classes = LMSClass::where('dosen_id', auth()->id())->with('students')->get();
        return view('dosen.certificates.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $class = LMSClass::findOrFail($validated['class_id']);
        if ($class->dosen_id !== auth()->id()) abort(403);

        $count = 0;
        foreach ($validated['user_ids'] as $userId) {
            $exists = Certificate::where('user_id', $userId)
                ->where('class_id', $class->id)
                ->exists();

            if (!$exists) {
                Certificate::create([
                    'user_id' => $userId,
                    'class_id' => $class->id,
                    'issued_at' => now(),
                ]);
                $count++;
            }
        }

        return redirect()->route('dosen.certificates.index')
            ->with('success', "$count sertifikat berhasil diterbitkan.");
    }

    public function download(Certificate $certificate)
    {
        if ($certificate->class->dosen_id !== auth()->id()) abort(403);

        $pdf = Pdf::loadView('certificates.template', compact('certificate'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('sertifikat-' . $certificate->certificate_number . '.pdf');
    }
}
