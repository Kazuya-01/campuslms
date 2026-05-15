@extends('layouts.dosen')

@section('title', 'Create Quiz - CampusLMS')
@section('page-title', 'Buat Quiz Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('dosen.quizzes.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                    <select name="class_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selectedClass?->id === $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Quiz</label>
                    <input type="text" name="title" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batas Waktu (menit)</label>
                        <input type="number" name="time_limit" min="1" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Kosongkan jika tidak ada batas">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai Maksimal</label>
                        <input type="number" name="max_score" value="100" min="0" step="0.01" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="random_questions" value="1" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 dark:bg-gray-700">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Acak Soal</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="random_answers" value="1" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 dark:bg-gray-700">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Acak Jawaban</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="allow_review" value="1" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 dark:bg-gray-700">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Izinkan Review Hasil</span>
                    </label>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('dosen.quizzes.index') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Buat Quiz</button>
            </div>
        </form>
    </div>
</div>
@endsection
