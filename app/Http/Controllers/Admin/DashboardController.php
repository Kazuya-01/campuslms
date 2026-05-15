<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\LMSClass;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_classes' => LMSClass::count(),
            'total_materials' => Material::count(),
            'total_assignments' => Assignment::count(),
            'total_quizzes' => Quiz::count(),
            'active_dosens' => User::role('dosen')->count(),
            'active_mahasiswas' => User::role('mahasiswa')->count(),
            'total_announcements' => Announcement::count(),
        ];

        $recentUsers = User::latest()->take(10)->get();
        $recentClasses = LMSClass::with('dosen')->latest()->take(5)->get();
        $recentAnnouncements = Announcement::with('user')->latest()->take(5)->get();

        $enrollmentStats = LMSClass::withCount('students')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($class) => [
                'name' => $class->name,
                'students' => $class->students_count,
            ]);

        $gradeDistribution = [
            'labels' => ['A (≥85)', 'B (70-84)', 'C (55-69)', 'D (40-54)', 'E (<40)'],
            'data' => [
                Grade::where('type', 'final')->where('score', '>=', 85)->count(),
                Grade::where('type', 'final')->whereBetween('score', [70, 84.99])->count(),
                Grade::where('type', 'final')->whereBetween('score', [55, 69.99])->count(),
                Grade::where('type', 'final')->whereBetween('score', [40, 54.99])->count(),
                Grade::where('type', 'final')->where('score', '<', 40)->count(),
            ],
        ];

        $monthlyActivity = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyActivity[] = [
                'month' => $month->format('M'),
                'assignments' => Assignment::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
                'quizzes' => Quiz::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentClasses',
            'recentAnnouncements',
            'enrollmentStats',
            'gradeDistribution',
            'monthlyActivity'
        ));
    }
}
