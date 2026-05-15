@extends('layouts.mahasiswa')

@section('title', $quiz->title . ' - CampusLMS')
@section('page-title', '')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-4 flex items-center justify-between sticky top-16 z-20">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">{{ substr($quiz->title, 0, 1) }}</div>
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $quiz->title }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $quiz->questions->count() }} soal</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            @if($quiz->time_limit)
                <div x-data="{ 
                    timeLeft: {{ $quiz->time_limit * 60 }},
                    init() {
                        setInterval(() => {
                            this.timeLeft--;
                            if (this.timeLeft <= 0) {
                                document.getElementById('quiz-form').requestSubmit();
                            }
                        }, 1000);
                    },
                    format(t) {
                        let m = Math.floor(t / 60);
                        let s = t % 60;
                        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                    }
                }" class="flex items-center space-x-2 px-3 py-1.5 rounded-lg" :class="timeLeft < 60 ? 'bg-red-50 dark:bg-red-900/20' : 'bg-purple-50 dark:bg-purple-900/20'">
                    <svg class="w-4 h-4" :class="timeLeft < 60 ? 'text-red-500' : 'text-purple-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-text="format(timeLeft)" class="font-bold tabular-nums" :class="timeLeft < 60 ? 'text-red-600' : 'text-purple-600'"></span>
                </div>
            @endif
            <span class="text-xs text-gray-400">|</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $quiz->max_score }} poin</span>
        </div>
    </div>

    <div class="flex gap-4">
        {{-- Question Navigator --}}
        <div class="hidden lg:block w-48 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-3 sticky top-40">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Navigasi</p>
                <div class="grid grid-cols-4 gap-1.5">
                    @foreach($quiz->questions as $index => $q)
                        <a href="#q{{ $index + 1 }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-medium border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-purple-100 dark:hover:bg-purple-900/30 hover:border-purple-300 transition-colors">
                            {{ $index + 1 }}
                        </a>
                    @endforeach
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button form="quiz-form" type="submit" class="w-full px-3 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white text-xs font-medium rounded-lg transition-all"
                            onclick="return confirm('Yakin ingin mengumpulkan? Jawaban tidak bisa diubah lagi.')">
                        Kumpulkan
                    </button>
                </div>
            </div>
        </div>

        {{-- Questions --}}
        <div class="flex-1 min-w-0">
            <form id="quiz-form" action="{{ route('mahasiswa.quizzes.submit', $quiz) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <div id="q{{ $index + 1 }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 scroll-mt-24">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 text-white text-xs font-bold flex items-center justify-center">{{ $index + 1 }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $question->type_label }}</span>
                                </div>
                                <span class="text-xs font-medium text-gray-400">{{ $question->points }} poin</span>
                            </div>

                            <p class="text-gray-900 dark:text-white font-medium mb-4 leading-relaxed">{{ $question->question }}</p>

                            @if($question->type === 'multiple_choice' && $question->options)
                                <div class="space-y-2">
                                    @foreach($question->options as $key => $option)
                                        <label x-data="{ checked: false }" :class="checked ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20 ring-1 ring-purple-500' : 'border-gray-200 dark:border-gray-700'" class="flex items-center p-3.5 rounded-xl border hover:border-purple-300 dark:hover:border-purple-600 hover:bg-purple-50/50 dark:hover:bg-purple-900/10 cursor-pointer transition-all">
                                            <input type="radio" name="question_{{ $question->id }}" value="{{ $key }}" @@change="checked = $el.checked" class="hidden" required>
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center mr-3 flex-shrink-0 transition-all" :class="checked ? 'border-purple-500 bg-purple-500' : 'border-gray-300 dark:border-gray-600'">
                                                <div x-show="checked" class="w-2 h-2 rounded-full bg-white"></div>
                                            </div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300" :class="checked && 'text-purple-700 dark:text-purple-300'">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <textarea name="question_{{ $question->id }}" rows="4" required 
                                    class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-purple-500 focus:ring-purple-500 resize-y"
                                    placeholder="Tulis jawaban Anda di sini..."></textarea>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $quiz->questions->count() }} soal &bull; klik "Kumpulkan" jika sudah selesai</span>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg transition-all"
                            onclick="return confirm('Yakin ingin mengumpulkan? Pastikan semua jawaban sudah diisi.')">
                        Kumpulkan Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
