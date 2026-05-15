@extends('layouts.mahasiswa')

@section('title', $class->name . ' - CampusLMS')
@section('page-title', $class->name)

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="h-40 bg-gradient-to-br from-blue-500 to-cyan-600 flex items-end p-6">
            <div class="flex items-center space-x-4 text-white">
                <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <span class="text-2xl font-bold">{{ substr($class->name, 0, 2) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $class->name }}</h2>
                    <p class="text-blue-100 text-sm">{{ $class->dosen?->name }} &bull; {{ $class->code }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-3 flex items-center">
            <div class="flex-1">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="text-gray-500 dark:text-gray-400">Progress Belajar</span>
                    <span class="font-medium text-gray-800 dark:text-white">{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2.5 rounded-full transition-all duration-700" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Announcements --}}
    @if($class->announcements->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Pengumuman</h3>
            @foreach($class->announcements->take(3) as $announcement)
                <div class="py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <div class="flex items-start space-x-2">
                        @if($announcement->is_pinned)<span class="text-xs px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded flex-shrink-0">Pinned</span>@endif
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $announcement->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Materials --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Materi Pembelajaran</h3>
        <div class="space-y-2">
            @forelse($class->materials as $material)
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <a href="{{ route('mahasiswa.classes.materials.view', [$class->slug, $material]) }}" class="flex items-center space-x-3 flex-1">
                        @if($material->type === 'file')
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        @elseif($material->type === 'video')
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $material->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pertemuan {{ $material->meeting_number ?? '-' }}</p>
                        </div>
                    </a>
                    <div class="flex items-center space-x-2">
                        @if(in_array($material->id, $completedMaterials))
                            <span class="text-xs text-green-600 dark:text-green-400 font-medium">Selesai</span>
                        @else
                            <form action="{{ route('mahasiswa.classes.materials.mark', [$class->slug, $material]) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Tandai Selesai</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada materi.</p>
            @endforelse
        </div>
    </div>

        {{-- Quizzes --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Quiz</h3>
        <div class="space-y-2">
            @forelse($class->quizzes as $quiz)
                <a href="{{ route('mahasiswa.quizzes.show', $quiz) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $quiz->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $quiz->questions->count() }} soal{{ $quiz->time_limit ? ' | ' . $quiz->time_limit . ' menit' : '' }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $quiz->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $quiz->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada quiz.</p>
            @endforelse
        </div>
    </div>

    {{-- Assignments --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tugas</h3>
        <div class="space-y-2">
            @forelse($class->assignments as $assignment)
                @php $submission = $assignment->submissions->first(); @endphp
                <a href="{{ route('mahasiswa.assignments.show', $assignment) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $assignment->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Deadline: {{ $assignment->deadline?->format('M d, Y H:i') ?? 'No deadline' }} &bull; Max: {{ $assignment->max_score }}</p>
                    </div>
                    <div class="text-right">
                        @if($submission && $submission->score !== null)
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $submission->score }}/{{ $assignment->max_score }}</span>
                        @elseif($submission)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">Submitted</span>
                        @else
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">Not Yet</span>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada tugas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
