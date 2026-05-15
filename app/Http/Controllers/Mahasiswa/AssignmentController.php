<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $classIds = auth()->user()->enrolledClasses()->pluck('class_id');
        $assignments = Assignment::whereIn('class_id', $classIds)
            ->with('class')
            ->latest()
            ->paginate(20);

        return view('mahasiswa.assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $user = auth()->user();
        $class = $assignment->class;

        if (! $user->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403);
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', $user->id)
            ->first();

        return view('mahasiswa.assignments.show', compact('assignment', 'class', 'submission'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $user = auth()->user();
        $class = $assignment->class;

        if (! $user->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:5000',
            'file' => 'required|file|max:51200',
        ]);

        $isLate = $assignment->deadline && now()->gt($assignment->deadline);

        $submission = AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => $user->id,
            ],
            [
                'file_path' => $request->file('file')->store('submissions', 'public'),
                'notes' => $validated['notes'] ?? null,
                'status' => $isLate ? 'late' : 'submitted',
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('mahasiswa.assignments.show', $assignment)
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
