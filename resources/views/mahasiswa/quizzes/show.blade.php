@extends('layouts.mahasiswa')

@section('title', $quiz->title . ' - CampusLMS')
@section('page-title', $quiz->title)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 text-center">
        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $quiz->title }}</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-6">{{ $quiz->description ?? 'Tidak ada deskripsi.' }}</p>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $quiz->questions->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Soal</p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $quiz->time_limit ? $quiz->time_limit . ' mnt' : 'Tidak' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Batas Waktu</p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $quiz->max_score }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Poin Maks</p>
            </div>
        </div>

        @if($existingAttempt)
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300 text-sm">
                Kamu sudah mengerjakan quiz ini. <a href="{{ route('mahasiswa.quizzes.result', $quiz) }}" class="underline font-medium">Lihat hasil</a>
            </div>
        @else
            <form action="{{ route('mahasiswa.quizzes.start', $quiz) }}" method="POST">
                @csrf
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg transition-all">
                    Mulai Quiz
                </button>
            </form>
            <p class="text-xs text-gray-400 mt-3">Pastikan koneksi stabil. Quiz tidak bisa diulang.</p>
        @endif
    </div>
</div>
@endsection
