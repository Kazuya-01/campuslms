<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Source 1: graded assignment submissions (definitive)
        $gradedSubmissions = AssignmentSubmission::where('user_id', $userId)
            ->whereNotNull('score')
            ->with('assignment.class')
            ->get()
            ->filter(fn ($s) => $s->assignment && $s->assignment->class)
            ->map(fn ($s) => [
                'id' => 'sub-'.$s->id,
                'class_id' => $s->assignment->class_id,
                'class_name' => $s->assignment->class?->name ?? 'Kelas',
                'title' => $s->assignment->title,
                'type' => 'assignment',
                'type_label' => 'Tugas',
                'score' => (float) $s->score,
                'max_score' => (float) $s->assignment->max_score,
                'percentage' => $s->assignment->max_score > 0 ? round(((float) $s->score / (float) $s->assignment->max_score) * 100, 2) : 0,
            ]);

        // Source 2: grade records from grades table (quiz, final, etc.)
        $gradeRecords = Grade::where('user_id', $userId)
            ->with('class', 'assignment', 'quiz')
            ->get()
            ->map(fn ($g) => [
                'id' => 'grade-'.$g->id,
                'class_id' => $g->class_id,
                'class_name' => $g->class?->name ?? 'Kelas',
                'title' => $g->assignment?->title ?? $g->quiz?->title ?? $g->type_label,
                'type' => $g->type,
                'type_label' => $g->type_label,
                'score' => (float) $g->score,
                'max_score' => (float) $g->max_score,
                'percentage' => $g->percentage,
            ]);

        // Merge: indexed by id to avoid duplicates
        $all = collect();
        foreach ($gradedSubmissions as $gs) {
            $all->put($gs['id'], $gs);
        }
        foreach ($gradeRecords as $gr) {
            if ($gr['type'] === 'assignment') {
                // Skip assignment-type grades from grades table (already from submissions)
                continue;
            }
            $all->put($gr['id'], $gr);
        }

        $allGrades = $all->sortByDesc(fn ($g) => $g['score'])->groupBy('class_id');

        return view('mahasiswa.grades.index', compact('allGrades'));
    }
}
