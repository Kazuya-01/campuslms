@extends('layouts.dosen')

@section('title', $assignment->title . ' - CampusLMS')
@section('page-title', $assignment->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-900 dark:text-white">Detail Tugas</h3>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $assignment->status === 'open' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">{{ $assignment->status }}</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $assignment->description ?? 'No description.' }}</p>
            <div class="mt-4 grid grid-cols-3 gap-4 text-sm">
                <div><span class="text-gray-500 dark:text-gray-400">Max Score:</span> <span class="font-medium text-gray-800 dark:text-white">{{ $assignment->max_score }}</span></div>
                <div><span class="text-gray-500 dark:text-gray-400">Deadline:</span> <span class="font-medium text-gray-800 dark:text-white">{{ $assignment->deadline?->format('M d, Y H:i') ?? 'No deadline' }}</span></div>
                <div><span class="text-gray-500 dark:text-gray-400">Class:</span> <span class="font-medium text-gray-800 dark:text-white">{{ $assignment->class?->name }}</span></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Submissions ({{ $assignment->submissions->count() }})</h3>
            @forelse($assignment->submissions as $submission)
                <div class="p-4 rounded-lg border border-gray-100 dark:border-gray-700 mb-3 last:mb-0">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $submission->user?->avatar_url }}" alt="" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white text-sm">{{ $submission->user?->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Submitted {{ $submission->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                            @if($submission->status === 'graded') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                            @elseif($submission->status === 'late') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                            @else bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300
                            @endif">
                            {{ $submission->status_label }}
                        </span>
                    </div>

                    @if($submission->file_path)
                        <div class="mt-2">
                            <a href="{{ $submission->file_url }}" target="_blank" class="inline-flex items-center space-x-1 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Download File Tugas</span>
                            </a>
                        </div>
                    @endif
                    @if($submission->notes)
                        <div class="mt-2 text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Catatan:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $submission->notes }}</p>
                        </div>
                    @endif
                    @if($submission->score !== null)
                        <div class="mt-2 text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Score:</span>
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $submission->score }}/{{ $assignment->max_score }}</span>
                            @if($submission->feedback)
                                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $submission->feedback }}</p>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('dosen.assignments.grade', $submission) }}" method="POST" class="mt-3 space-y-2">
                            @csrf
                            <div class="flex items-center space-x-2">
                                <input type="number" name="score" placeholder="Score (max {{ $assignment->max_score }})" required min="0" max="{{ $assignment->max_score }}" step="0.01" class="w-40 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                <button type="submit" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg">Grade</button>
                            </div>
                            <textarea name="feedback" rows="2" placeholder="Feedback..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"></textarea>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">No submissions yet.</p>
            @endforelse
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <form action="{{ route('dosen.assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Hapus tugas ini? Semua pengumpulan juga akan ikut terhapus.')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">Hapus Tugas</button>
            </form>
        </div>
    </div>
</div>
@endsection
