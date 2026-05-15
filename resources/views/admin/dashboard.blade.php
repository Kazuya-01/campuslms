@extends('layouts.admin')

@section('title', 'Admin Dashboard - CampusLMS')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="text-green-600 dark:text-green-400 font-medium">{{ $stats['active_dosens'] }} Dosen</span>
                <span class="mx-2">&bull;</span>
                <span class="text-blue-600 dark:text-blue-400 font-medium">{{ $stats['active_mahasiswas'] }} Mahasiswa</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Classes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_classes']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="font-medium">{{ $stats['total_materials'] }} Materials</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Assignments</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_assignments']) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span class="font-medium">{{ $stats['total_quizzes'] }} Quizzes</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Announcements</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_announcements']) }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Enrollment Chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Student Enrollment by Class</h3>
            <div class="space-y-3">
                @forelse($enrollmentStats as $stat)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 dark:text-gray-400 truncate">{{ $stat['name'] }}</span>
                            <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $stat['students'] }} students</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, ($stat['students'] / max(1, $enrollmentStats->max('students'))) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No class data available.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Recent Users</h3>
            <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse($recentUsers as $user)
                    <div class="flex-shrink-0 w-56 snap-start p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $user->avatar_url }}" alt="" class="w-8 h-8 rounded-full flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No users yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Distribusi Nilai Akhir</h3>
            <canvas id="gradeChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Aktivitas Bulanan</h3>
            <canvas id="activityChart" height="200"></canvas>
        </div>
    </div>

    @push('scripts')
    <script>
        new Chart(document.getElementById('gradeChart'), {
            type: 'doughnut',
            data: {
                labels: @json($gradeDistribution['labels']),
                datasets: [{ data: @json($gradeDistribution['data']), backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'] }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
        new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: @json(collect($monthlyActivity)->pluck('month')),
                datasets: [
                    { label: 'Tugas', data: @json(collect($monthlyActivity)->pluck('assignments')), backgroundColor: '#6366f1' },
                    { label: 'Quiz', data: @json(collect($monthlyActivity)->pluck('quizzes')), backgroundColor: '#a855f7' },
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
    @endpush

    {{-- Recent Classes & Announcements --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900 dark:text-white">Recent Classes</h3>
                <a href="{{ route('admin.classes.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">View All</a>
            </div>
            <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse($recentClasses as $class)
                    <div class="flex-shrink-0 w-64 snap-start p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ substr($class->name, 0, 2) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $class->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $class->dosen?->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $class->code }}</span>
                            <span class="text-xs text-gray-400">{{ $class->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No classes yet.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900 dark:text-white">Recent Announcements</h3>
                <a href="{{ route('admin.announcements.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">View All</a>
            </div>
            <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse($recentAnnouncements as $announcement)
                    <div class="flex-shrink-0 w-64 snap-start p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $announcement->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $announcement->user?->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ Str::limit($announcement->content, 100) }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No announcements yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
