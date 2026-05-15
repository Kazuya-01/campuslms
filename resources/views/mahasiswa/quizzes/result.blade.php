@extends('layouts.mahasiswa')

@section('title', 'Hasil Quiz - CampusLMS')
@section('page-title', 'Hasil Quiz: ' . $quiz->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 text-center mb-6">
        <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 {{ $attempt->score && $attempt->total_points && $attempt->score / $attempt->total_points >= 0.7 ? 'bg-green-100 dark:bg-green-900/30' : 'bg-orange-100 dark:bg-orange-900/30' }}">
            <span class="text-3xl font-bold {{ $attempt->score && $attempt->total_points && $attempt->score / $attempt->total_points >= 0.7 ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400' }}">
                {{ $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100) : 0 }}
            </span>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Nilai Kamu</p>
        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $attempt->score }}/{{ $attempt->total_points }} poin</p>
        <div class="mt-3 w-full max-w-xs mx-auto bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="h-3 rounded-full transition-all {{ $attempt->total_points > 0 && ($attempt->score / $attempt->total_points) >= 0.7 ? 'bg-gradient-to-r from-blue-500 to-cyan-500' : 'bg-gradient-to-r from-orange-500 to-red-500' }}" 
                 style="width: {{ $attempt->total_points > 0 ? ($attempt->score / $attempt->total_points) * 100 : 0 }}%"></div>
        </div>
        <p class="text-xs text-gray-400 mt-2">Selesai: {{ $attempt->finished_at->format('d M Y H:i') }}</p>
    </div>

    @if($quiz->allow_review)
        <div class="space-y-4">
            <h3 class="font-semibold text-gray-900 dark:text-white">Review Jawaban</h3>
            @foreach($attempt->answers as $index => $answer)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $answer->question->type === 'multiple_choice' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' }}">
                            Soal {{ $index + 1 }} &bull; {{ $answer->question->points }} poin
                        </span>
                        @if($answer->is_correct !== null)
                            <span class="text-xs font-medium {{ $answer->is_correct ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $answer->is_correct ? 'Benar (+' . $answer->points_earned . ')' : 'Salah (0)' }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400">Menunggu penilaian</span>
                        @endif
                    </div>
                    <p class="text-gray-900 dark:text-white font-medium mb-2">{{ $answer->question->question }}</p>
                    @php
                        $options = $answer->question->options ?? [];
                        $firstOpt = $options[0] ?? null;
                        if (is_array($firstOpt)) {
                            $selectedLabel = collect($options)->firstWhere('value', $answer->answer)['label'] ?? $answer->answer;
                            $correctLabel = collect($options)->firstWhere('value', $answer->question->correct_answer)['label'] ?? $answer->question->correct_answer;
                        } else {
                            $selectedLabel = $answer->answer;
                            $correctLabel = $options[(int)$answer->question->correct_answer] ?? $answer->question->correct_answer;
                        }
                    @endphp
                    @if($answer->question->type === 'multiple_choice')
                        <p class="text-sm text-gray-600 dark:text-gray-400">Jawabanmu: <span class="{{ $answer->is_correct ? 'text-green-600 font-medium' : 'text-red-600' }}">{{ $selectedLabel }}</span></p>
                        @if(!$answer->is_correct)
                            <p class="text-sm text-green-600">Jawaban benar: {{ $correctLabel }}</p>
                        @endif
                    @else
                        <p class="text-sm text-gray-600 dark:text-gray-400">Jawaban: {{ $answer->answer }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('mahasiswa.quizzes.index') }}" class="inline-block px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Kembali ke Daftar Quiz</a>
    </div>
</div>
@endsection
