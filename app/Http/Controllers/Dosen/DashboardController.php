<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\LMSClass;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();
        $myClasses = LMSClass::where('dosen_id', $dosenId)->get();
        $classIds = $myClasses->pluck('id');

        $stats = [
            'total_classes' => $myClasses->count(),
            'total_students' => \DB::table('class_user')->whereIn('class_id', $classIds)->count(),
            'total_assignments' => Assignment::whereIn('class_id', $classIds)->count(),
            'ungraded_submissions' => AssignmentSubmission::whereIn('assignment_id', function ($q) use ($classIds) {
                $q->select('id')->from('assignments')->whereIn('class_id', $classIds);
            })->whereNull('score')->count(),
            'active_quizzes' => Quiz::whereIn('class_id', $classIds)->where('is_active', true)->count(),
        ];

        $recentSubmissions = AssignmentSubmission::with(['assignment', 'user'])
            ->whereIn('assignment_id', function ($q) use ($classIds) {
                $q->select('id')->from('assignments')->whereIn('class_id', $classIds);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dosen.dashboard', compact('myClasses', 'stats', 'recentSubmissions'));
    }
}
