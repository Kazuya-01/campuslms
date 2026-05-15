@extends('layouts.mahasiswa')

@section('title', 'Forum - ' . $class->name . ' - CampusLMS')
@section('page-title', 'Forum: ' . $class->name)

@section('content')
<div class="space-y-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr($class->name, 0, 2) }}
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $class->name }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->forumThreads->count() }} diskusi</p>
                </div>
            </div>
            <a href="{{ route('mahasiswa.forum.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">← Semua Forum</a>
        </div>

        <div class="space-y-1">
            @forelse($class->forumThreads as $thread)
                <a href="{{ route('mahasiswa.forum.show', $thread) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ substr($thread->user?->name ?? '?', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">
                            {{ $thread->title }}
                            @if($thread->is_pinned)
                                <span class="text-xs px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded ml-1">Pinned</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $thread->user?->name }} &bull; {{ $thread->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400 flex-shrink-0">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            {{ $thread->replies_count }}
                        </span>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada thread diskusi di kelas ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
