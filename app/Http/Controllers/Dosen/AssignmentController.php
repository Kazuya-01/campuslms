<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Grade;
use App\Models\LMSClass;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $classIds = LMSClass::where('dosen_id', auth()->id())->pluck('id');
        $assignments = Assignment::whereIn('class_id', $classIds)
            ->with('class', 'submissions')
            ->latest()
            ->paginate(20);

        return view('dosen.assignments.index', compact('assignments'));
    }

    public function create(Request $request)
    {
        $classes = LMSClass::where('dosen_id', auth()->id())->get();
        $selectedClass = $request->class_id ? LMSClass::find($request->class_id) : null;

        return view('dosen.assignments.create', compact('classes', 'selectedClass'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:0|max:999999.99',
            'deadline' => 'nullable|date',
            'instructions' => 'nullable|string',
            'file_path' => 'nullable|file|max:10240',
        ]);

        $class = LMSClass::findOrFail($validated['class_id']);
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }

        $assignment = Assignment::create([
            'class_id' => $validated['class_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'max_score' => $validated['max_score'],
            'deadline' => $validated['deadline'] ?? null,
            'instructions' => $validated['instructions'] ?? null,
        ]);

        if ($request->hasFile('file_path')) {
            $assignment->update(['file_path' => $request->file('file_path')->store('assignments', 'public')]);
        }

        NotificationService::sendToClass($assignment->class_id, 'assignment', 'New Assignment: '.$assignment->title, $assignment->description);

        return redirect()->route('dosen.assignments.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Assignment $assignment)
    {
        if ($assignment->class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $assignment->load('submissions.user', 'class');

        return view('dosen.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        if ($assignment->class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $classes = LMSClass::where('dosen_id', auth()->id())->get();

        return view('dosen.assignments.edit', compact('assignment', 'classes'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->class->dosen_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'instructions' => 'nullable|string',
        ]);

        $assignment->update($validated);

        if ($request->hasFile('file_path')) {
            $assignment->update(['file_path' => $request->file('file_path')->store('assignments', 'public')]);
        }

        return redirect()->route('dosen.assignments.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $assignment->delete();

        return redirect()->route('dosen.assignments.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function grade(Request $request, AssignmentSubmission $submission)
    {
        if ($submission->assignment->class->dosen_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:'.$submission->assignment->max_score,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'] ?? null,
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        if ($request->hasFile('feedback_file')) {
            $submission->update(['feedback_file' => $request->file('feedback_file')->store('feedback', 'public')]);
        }

        $grade = Grade::updateOrCreate(
            [
                'user_id' => $submission->user_id,
                'class_id' => $submission->assignment->class_id,
                'assignment_id' => $submission->assignment_id,
                'type' => 'assignment',
            ],
            [
                'score' => $validated['score'],
                'max_score' => $submission->assignment->max_score,
            ]
        );

        if (! $grade->wasRecentlyCreated && ! $grade->wasChanged()) {
            \Log::warning('Grade not saved', ['grade_id' => $grade->id, 'user_id' => $submission->user_id]);
        }

        NotificationService::send($submission->user_id, 'grade', 'Tugas Dinilai: '.$submission->assignment->title, 'Nilai: '.$validated['score']);

        return back()->with('success', 'Nilai berhasil diberikan.');
    }
}
