@extends('layouts.mahasiswa')

@section('title', 'Quiz - CampusLMS')
@section('page-title', 'Quiz')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($quizzes as $quiz)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if(in_array($quiz->id, $attempted))
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Selesai</span>
                @else
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300">Tersedia</span>
                @endif
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $quiz->title }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $quiz->class?->name }} &bull; {{ $quiz->questions->count() }} soal</p>
            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-3">
                @if($quiz->time_limit)
                    <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $quiz->time_limit }} menit</span>
                @endif
                <span>{{ $quiz->max_score }} poin</span>
            </div>
            @if(in_array($quiz->id, $attempted))
                <a href="{{ route('mahasiswa.quizzes.result', $quiz) }}" class="block w-full text-center px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Lihat Hasil</a>
            @else
                <form action="{{ route('mahasiswa.quizzes.start', $quiz) }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-center px-3 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-all cursor-pointer">Mulai Quiz</button>
                </form>
            @endif
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-lg font-medium">Belum ada quiz</p>
            <p class="text-sm mt-1">Quiz akan muncul setelah dosen menerbitkannya.</p>
        </div>
    @endforelse
</div>
@if($quizzes->hasPages())<div class="mt-4">{{ $quizzes->links() }}</div>@endif
@endsection
