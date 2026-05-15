<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LMSClass;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->dosenClasses()
            ->with(['assignments' => fn($q) => $q->whereNotNull('deadline'), 'quizzes'])
            ->get();

        $events = collect();

        foreach ($classes as $class) {
            foreach ($class->assignments as $assignment) {
                if ($assignment->deadline) {
                    $events->push([
                        'title' => 'Tugas: ' . $assignment->title,
                        'date' => $assignment->deadline->format('Y-m-d'),
                        'time' => $assignment->deadline->format('H:i'),
                        'class' => $class->name,
                        'color' => 'emerald',
                        'url' => route('dosen.assignments.show', $assignment),
                        'type' => 'assignment',
                    ]);
                }
            }
            foreach ($class->quizzes as $quiz) {
                $events->push([
                    'title' => 'Quiz: ' . $quiz->title,
                    'date' => $quiz->created_at->format('Y-m-d'),
                    'class' => $class->name,
                    'color' => 'purple',
                    'url' => '#',
                    'type' => 'quiz',
                ]);
            }
        }

        $events = $events->sortBy('date')->values();

        return view('dosen.calendar.index', compact('events', 'classes'));
    }
}
