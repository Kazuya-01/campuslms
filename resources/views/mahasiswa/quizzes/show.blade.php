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
            <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-700 rounded-xl text-left">
                <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-2">Peraturan Quiz:</p>
                <ul class="text-xs text-amber-700 dark:text-amber-400 space-y-1.5">
                    <li class="flex items-start space-x-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Dilarang membuka tab baru atau meninggalkan halaman quiz</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        <span>Dilarang menggunakan copy-paste dan developer tools</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $quiz->time_limit ? 'Batas waktu ' . $quiz->time_limit . ' menit. Quiz otomatis dikumpulkan saat waktu habis.' : 'Tidak ada batas waktu' }}</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Quiz hanya bisa dikerjakan satu kali dan tidak bisa diulang</span>
                    </li>
                </ul>
            </div>
            <form action="{{ route('mahasiswa.quizzes.start', $quiz) }}" method="POST">
                @csrf
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg transition-all">
                    Mulai Quiz
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
