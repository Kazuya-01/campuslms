<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
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

        // Enrollment stats for chart
        $enrollmentStats = LMSClass::withCount('students')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($class) => [
                'name' => $class->name,
                'students' => $class->students_count,
            ]);

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentClasses',
            'recentAnnouncements',
            'enrollmentStats'
        ));
    }
}
