<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = LMSClass::where('dosen_id', auth()->id())
            ->withCount('students', 'materials', 'assignments')
            ->latest()
            ->paginate(20);

        return view('dosen.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('dosen.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $class = LMSClass::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
            'level' => $validated['level'] ?? null,
            'dosen_id' => auth()->id(),
        ]);

        if ($request->hasFile('thumbnail')) {
            $class->update(['thumbnail' => $request->file('thumbnail')->store('classes', 'public')]);
        }

        return redirect()->route('dosen.classes.show', $class->slug)->with('success', 'Class created successfully. Share code: '.$class->code);
    }

    public function show(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $class->load(['materials' => fn ($q) => $q->ordered(), 'assignments.submissions', 'quizzes', 'students' => fn ($q) => $q->withPivot('progress')]);

        return view('dosen.classes.show', compact('class'));
    }

    public function edit(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }

        return view('dosen.classes.edit', compact('class'));
    }

    public function update(Request $request, LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
        ]);

        $class->update($validated);

        if ($request->hasFile('thumbnail')) {
            $class->update(['thumbnail' => $request->file('thumbnail')->store('classes', 'public')]);
        }

        return redirect()->route('dosen.classes.show', $class->slug)->with('success', 'Class updated.');
    }

    public function students(LMSClass $class)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $students = $class->students()->withPivot('progress')->latest()->paginate(20);

        return view('dosen.classes.students', compact('class', 'students'));
    }

    public function removeStudent(LMSClass $class, $userId)
    {
        if ($class->dosen_id !== auth()->id()) {
            abort(403);
        }
        $class->students()->detach($userId);

        return back()->with('success', 'Student removed.');
    }
}
