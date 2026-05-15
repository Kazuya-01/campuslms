@extends('layouts.mahasiswa')

@section('title', 'Dashboard - CampusLMS')
@section('page-title', 'Dashboard Mahasiswa')

@section('content')
<div class="space-y-6">
    {{-- Progress Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas Diikuti</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $myClasses->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tugas Tertunda</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $pendingAssignments }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Quiz Tersedia</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $quizzes }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sertifikat</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ auth()->user()->certificates()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Class Progress --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Progress Pembelajaran</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($classesWithProgress as $cp)
                <a href="{{ route('mahasiswa.classes.show', $cp['slug']) }}" class="block p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:shadow-md transition-all">
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="{{ $cp['thumbnail'] }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $cp['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $cp['dosen'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="text-gray-500 dark:text-gray-400">Progress</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $cp['progress'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2 rounded-full transition-all duration-700" style="width: {{ $cp['progress'] }}%"></div>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm col-span-3">Belum terdaftar di kelas manapun.</p>
            @endforelse
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Upcoming Assignments --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tugas Mendekati Deadline</h3>
            <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse($upcomingAssignments as $assignment)
                    <div class="flex-shrink-0 w-72 snap-start p-4 rounded-lg bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-700">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $assignment->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $assignment->class?->name }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs text-gray-400">Due {{ $assignment->deadline?->diffForHumans() }}</span>
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300">{{ $assignment->deadline?->format('M d, H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada tugas mendekati deadline.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Grades --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Nilai Terbaru</h3>
            <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                @forelse($grades as $grade)
                    <div class="flex-shrink-0 w-56 snap-start p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">Nilai {{ $grade['type_label'] ?? $grade->type_label ?? 'Tugas' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $grade['class']?->name ?? $grade->class?->name ?? '-' }}</p>
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">{{ $grade['score'] ?? $grade->score }}<span class="text-sm text-gray-400">/{{ $grade['max_score'] ?? $grade->max_score }}</span></p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada nilai.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Announcements --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900 dark:text-white">Pengumuman Terbaru</h3>
        </div>
        <div class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
            @forelse($announcements as $announcement)
                <div class="flex-shrink-0 w-80 snap-start p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ substr($announcement->user?->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $announcement->title }}</p>
                                @if($announcement->is_pinned)
                                    <span class="text-xs px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded flex-shrink-0">Pinned</span>
                                @endif
                            </div>
                            <p title="{{ $announcement->content }}" class="text-sm text-gray-600 dark:text-gray-400 mt-1 truncate cursor-default">{{ $announcement->content }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $announcement->created_at->diffForHumans() }} &bull; oleh {{ $announcement->user?->name ?? 'System' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada pengumuman.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
