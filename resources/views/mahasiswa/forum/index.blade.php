@extends('layouts.mahasiswa')

@section('title', 'Forum Diskusi - CampusLMS')
@section('page-title', 'Forum Diskusi')

@section('content')
<div class="space-y-6">
    {{-- Recent Threads --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Diskusi Terbaru</h3>
        @forelse($recentThreads as $thread)
            <div class="flex items-start gap-3 py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ substr($thread->user?->name ?? '?', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('mahasiswa.forum.show', $thread) }}" class="text-sm font-medium text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">{{ $thread->title }}</a>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $thread->class?->name }} &bull; {{ $thread->user?->name }} &bull; {{ $thread->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400 flex-shrink-0">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        {{ $thread->replies_count }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada diskusi. Mulai diskusi dari halaman kelas masing-masing.</p>
        @endforelse
    </div>

    {{-- My Classes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($classes as $class)
            <a href="{{ route('mahasiswa.forum.class', $class) }}" class="block p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ substr($class->name, 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $class->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->forum_threads_count ?? $class->forumThreads->count() }} diskusi</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-400">
                    <span>{{ $class->dosen?->name ?? '-' }}</span>
                    <span class="font-medium text-blue-600 dark:text-blue-400">Lihat Forum →</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
