<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\LMSClass;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myClasses = $user->enrolledClasses()->with('dosen')->get();
        $classIds = $myClasses->pluck('id');

        $upcomingAssignments = Assignment::whereIn('class_id', $classIds)
            ->where('deadline', '>=', now())
            ->where('is_active', true)
            ->with('class')
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $grades = collect();

        $gradedSubmissions = AssignmentSubmission::where('user_id', $user->id)
            ->whereNotNull('score')
            ->with('assignment.class')
            ->latest()
            ->take(5)
            ->get()
            ->filter(fn($s) => $s->assignment && $s->assignment->class)
            ->map(fn($s) => [
                'class' => $s->assignment->class,
                'type_label' => 'Tugas',
                'score' => $s->score,
                'max_score' => $s->assignment->max_score,
            ]);

        $grades = $gradedSubmissions;

        if ($grades->isEmpty()) {
            $grades = \App\Models\Grade::with('class')
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        $announcements = Announcement::where(function ($q) use ($classIds) {
            $q->whereIn('class_id', $classIds)->orWhere('is_global', true);
        })
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $pendingAssignments = AssignmentSubmission::where('user_id', $user->id)
            ->whereNull('score')
            ->count();

        $quizzes = Quiz::whereIn('class_id', $classIds)->where('is_active', true)->count();

        $classesWithProgress = $user->enrolledClasses()
            ->withPivot('progress')
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'slug' => $c->slug,
                'progress' => $c->pivot->progress,
                'dosen' => $c->dosen->name,
                'thumbnail' => $c->thumbnail_url,
            ]);

        return view('mahasiswa.dashboard', compact(
            'myClasses',
            'upcomingAssignments',
            'grades',
            'announcements',
            'pendingAssignments',
            'quizzes',
            'classesWithProgress'
        ));
    }
}
