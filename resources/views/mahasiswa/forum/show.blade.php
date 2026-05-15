@extends('layouts.mahasiswa')

@section('title', $thread->title . ' - CampusLMS')
@section('page-title', 'Forum Diskusi')

@section('content')
<div class="max-w-4xl mx-auto space-y-4">
    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('mahasiswa.forum.index') }}" class="hover:text-blue-600">Forum</a>
        <span class="mx-1">/</span>
        <a href="{{ route('mahasiswa.forum.class', $thread->class) }}" class="hover:text-blue-600">{{ $thread->class?->name }}</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 dark:text-gray-200">{{ $thread->title }}</span>
    </div>

    {{-- Thread --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                {{ substr($thread->user?->name ?? '?', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $thread->title }}</h3>
                    @if($thread->is_pinned)
                        <span class="text-xs px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded">Pinned</span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $thread->user?->name }} &bull; {{ $thread->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
            {{ nl2br(e($thread->content)) }}
        </div>
    </div>

    {{-- Replies --}}
    <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">Balasan ({{ $thread->replies->count() }})</h4>

        @forelse($thread->replies as $reply)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 {{ $reply->parent_id ? 'ml-8 border-l-4 border-l-blue-400' : '' }}" id="reply-{{ $reply->id }}">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-500 to-gray-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ substr($reply->user?->name ?? '?', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $reply->user?->name }}</p>
                            <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">{{ nl2br(e($reply->content)) }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <form action="{{ route('mahasiswa.forum.like', $reply) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center gap-1 text-xs {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }} transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="{{ $reply->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                    {{ $reply->likes->count() }}
                                </button>
                            </form>
                            <button @@click="document.getElementById('reply-form-{{ $thread->id }}').querySelector('[name=parent_id]').value = '{{ $reply->id }}'; document.getElementById('reply-text-{{ $thread->id }}').focus();" class="text-xs text-gray-400 hover:text-blue-600 transition-colors">Balas</button>
                        </div>

                        {{-- Nested replies --}}
                        @foreach($reply->replies as $nested)
                            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white text-2xs font-bold flex-shrink-0">
                                    {{ substr($nested->user?->name ?? '?', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $nested->user?->name }}</p>
                                        <span class="text-2xs text-gray-400">{{ $nested->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ nl2br(e($nested->content)) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada balasan. Jadilah yang pertama!</p>
        @endforelse
    </div>

    {{-- Reply Form --}}
    <div id="reply-form-{{ $thread->id }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-3">Tulis Balasan</h4>
        <form action="{{ route('mahasiswa.forum.reply', $thread) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="">
            <textarea id="reply-text-{{ $thread->id }}" name="content" rows="3" required
                      class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-blue-500 focus:ring-blue-500 resize-y"
                      placeholder="Tulis balasan Anda..."></textarea>
            <div class="flex items-center justify-between mt-3">
                <span class="text-xs text-gray-400">Jaga sopan santun dalam berdiskusi</span>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm">
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
