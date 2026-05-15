<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->enrolledClasses()->with('dosen')->withPivot('progress')->get();
        $availableClasses = LMSClass::where('is_active', true)
            ->whereDoesntHave('students', fn($q) => $q->where('user_id', auth()->id()))
            ->with('dosen')
            ->take(6)
            ->get();
        return view('mahasiswa.classes.index', compact('classes', 'availableClasses'));
    }

    public function show(LMSClass $class)
    {
        $user = auth()->user();
        $isEnrolled = $user->enrolledClasses()->where('class_id', $class->id)->exists();
        if (!$isEnrolled) {
            return redirect()->route('mahasiswa.classes.index')->with('error', 'Anda belum terdaftar di kelas ini.');
        }

        $class->load([
            'materials' => fn($q) => $q->ordered(),
            'assignments' => fn($q) => $q->with(['submissions' => fn($sq) => $sq->where('user_id', $user->id)]),
            'quizzes.questions',
            'forumThreads' => fn($q) => $q->latest(),
            'announcements' => fn($q) => $q->latest(),
        ]);

        $enrollment = $user->enrolledClasses()->where('class_id', $class->id)->first();
        $progress = $enrollment?->pivot->progress ?? 0;

        $completedMaterials = MaterialProgress::where('user_id', $user->id)
            ->whereIn('material_id', $class->materials->pluck('id'))
            ->pluck('material_id')
            ->toArray();

        return view('mahasiswa.classes.show', compact('class', 'progress', 'completedMaterials'));
    }

    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6|exists:classes,code',
        ]);

        $class = LMSClass::where('code', $validated['code'])->firstOrFail();

        if (auth()->user()->enrolledClasses()->where('class_id', $class->id)->exists()) {
            return back()->with('error', 'Anda sudah terdaftar di kelas ini.');
        }

        auth()->user()->enrolledClasses()->attach($class->id, ['progress' => 0]);

        return redirect()->route('mahasiswa.classes.show', $class->slug)->with('success', 'Berhasil bergabung ke kelas ' . $class->name);
    }

    public function markMaterial(LMSClass $class, Material $material)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $class->id)->exists()) abort(403);

        MaterialProgress::firstOrCreate([
            'user_id' => $user->id,
            'material_id' => $material->id,
        ], ['completed_at' => now()]);

        $total = $class->materials()->count();
        $completed = MaterialProgress::where('user_id', $user->id)
            ->whereIn('material_id', $class->materials()->pluck('id'))
            ->count();

        $progress = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
        $user->enrolledClasses()->updateExistingPivot($class->id, ['progress' => $progress]);

        return redirect()->route('mahasiswa.classes.show', $class->slug)->with('success', 'Progress tersimpan.');
    }

    public function viewMaterial(LMSClass $class, Material $material)
    {
        $user = auth()->user();
        if (!$user->enrolledClasses()->where('class_id', $class->id)->exists()) abort(403);

        $isCompleted = MaterialProgress::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->exists();

        return view('mahasiswa.materials.view', compact('class', 'material', 'isCompleted'));
    }
}
