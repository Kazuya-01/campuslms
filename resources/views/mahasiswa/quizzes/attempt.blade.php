@extends('layouts.mahasiswa')

@section('title', $quiz->title . ' - CampusLMS')
@section('page-title', '')

@section('content')
<div class="max-w-4xl mx-auto" x-data="quizProtection()">
    {{-- Warning Modal --}}
    <div x-show="showWarning" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Anda Meninggalkan Halaman Quiz!</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Quiz akan otomatis dikumpulkan jika Anda tidak kembali dalam waktu <span class="font-bold text-red-500" x-text="warningTimer"></span> detik.
            </p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-6 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-red-500 to-orange-500 rounded-full transition-all duration-1000" :style="'width: ' + ((warningTimer / 10) * 100) + '%'"></div>
            </div>
            <button @@click="dismissWarning()" class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-medium rounded-xl transition-all shadow-lg">
                Kembali ke Quiz
            </button>
        </div>
    </div>

    {{-- Anti-cheat Toast Container --}}
    <div id="cheat-toast" class="fixed top-4 right-4 z-50 flex flex-col space-y-2"></div>

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-4 flex items-center justify-between">
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
                                document.getElementById('quiz-form').submit();
                            }
                        }, 1000);
                    },
                    format(t) {
                        let m = Math.floor(t / 60);
                        let s = t % 60;
                        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                    }
                }" class="flex items-center space-x-2 px-3 py-1.5 rounded-lg" :class="timeLeft < 60 ? 'bg-red-50 dark:bg-red-900/20 animate-pulse' : 'bg-purple-50 dark:bg-purple-900/20'">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-3 sticky top-16">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Navigasi</p>
                <div class="grid grid-cols-4 gap-1.5">
                    @foreach($quiz->questions as $index => $q)
                        <button type="button" @@click="goToQuestion({{ $index }})"
                                :class="answered['question_{{ $q->id }}'] ? 'bg-emerald-500 text-white border-emerald-500 hover:bg-emerald-600 hover:border-emerald-600' : (errors['question_{{ $q->id }}'] ? 'border-red-400 text-red-600 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-purple-100 dark:hover:bg-purple-900/30 hover:border-purple-300')"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-medium border transition-all">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button form="quiz-form" type="submit" class="w-full px-3 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white text-xs font-medium rounded-lg transition-all">
                        Kumpulkan
                    </button>
                </div>
            </div>
        </div>

        {{-- Questions --}}
        <div class="flex-1 min-w-0">
            <form id="quiz-form" action="{{ route('mahasiswa.quizzes.submit', $quiz) }}" method="POST" @@submit.prevent="handleSubmit()">
                @csrf
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <div id="q{{ $index + 1 }}" x-ref="q{{ $index }}" 
                             :class="errors['question_{{ $question->id }}'] ? 'border-red-400 dark:border-red-500 ring-1 ring-red-400 dark:ring-red-500' : 'border-gray-200 dark:border-gray-700'"
                             class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border p-5 scroll-mt-24 transition-all duration-300">
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
                                    @foreach($question->options as $option)
                                        <label x-data="{ checked: false }" :class="checked ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20 ring-1 ring-purple-500' : 'border-gray-200 dark:border-gray-700'" class="flex items-center p-3.5 rounded-xl border hover:border-purple-300 dark:hover:border-purple-600 hover:bg-purple-50/50 dark:hover:bg-purple-900/10 cursor-pointer transition-all">
                                            <input type="radio" name="question_{{ $question->id }}" value="{{ is_array($option) ? ($option['value'] ?? '') : $option }}" 
                                                   @@change="checked = $el.checked; markAnswered('question_{{ $question->id }}')" class="hidden">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center mr-3 flex-shrink-0 transition-all" :class="checked ? 'border-purple-500 bg-purple-500' : 'border-gray-300 dark:border-gray-600'">
                                                <div x-show="checked" class="w-2 h-2 rounded-full bg-white"></div>
                                            </div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300" :class="checked && 'text-purple-700 dark:text-purple-300'">{{ is_array($option) ? ($option['label'] ?? '') : $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <textarea name="question_{{ $question->id }}" rows="4" 
                                    @@input="markAnswered('question_{{ $question->id }}')"
                                    class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-purple-500 focus:ring-purple-500 resize-y"
                                    placeholder="Tulis jawaban Anda di sini..."></textarea>
                            @endif

                            <template x-if="errors['question_{{ $question->id }}']">
                                <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" class="flex items-center gap-1.5 mt-3 text-sm text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span>Soal ini harus dijawab</span>
                                </div>
                            </template>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $quiz->questions->count() }} soal &bull; klik "Kumpulkan" jika sudah selesai</span>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg transition-all">
                        Kumpulkan Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('quizProtection', () => ({
        showWarning: false,
        warningTimer: 10,
        warningInterval: null,
        formSubmitted: false,
        errors: {},
        answered: {},

        init() {
            this.preventCheating();
            this.trackVisibility();
            this.trackLeave();
            this.preventBackNavigation();
        },

        handleSubmit() {
            if (!this.validate()) return;

            if (!confirm('Yakin ingin mengumpulkan? Pastikan semua jawaban sudah diisi. Jawaban tidak bisa diubah lagi.')) return;

            this.formSubmitted = true;
            document.getElementById('quiz-form').submit();
        },

        validate() {
            this.errors = {};
            const questions = document.querySelectorAll('[name^="question_"]');
            let firstError = null;

            questions.forEach((input) => {
                const name = input.getAttribute('name');
                if (this.errors[name]) return;

                if (input.type === 'radio') {
                    const group = document.querySelectorAll(`input[name="${name}"]`);
                    const checked = Array.from(group).some(r => r.checked);
                    if (!checked) {
                        this.errors[name] = true;
                        if (!firstError) firstError = name;
                    }
                } else if (input.type === 'textarea' || input.tagName === 'TEXTAREA') {
                    if (!input.value.trim()) {
                        this.errors[name] = true;
                        if (!firstError) firstError = name;
                    }
                }
            });

            if (firstError) {
                const firstInput = document.querySelector(`[name="${firstError}"]`);
                const questionBlock = firstInput?.closest('[id^="q"]');
                if (questionBlock) {
                    questionBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            return Object.keys(this.errors).length === 0;
        },

        clearError(name) {
            delete this.errors[name];
        },

        markAnswered(name) {
            this.answered[name] = true;
            this.clearError(name);
        },

        goToQuestion(index) {
            const el = document.getElementById('q' + (index + 1));
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        },

        preventCheating() {
            document.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                this.showToast('Mengklik kanan tidak diizinkan selama quiz');
            });

            document.addEventListener('copy', (e) => e.preventDefault());
            document.addEventListener('paste', (e) => e.preventDefault());
            document.addEventListener('cut', (e) => e.preventDefault());

            document.addEventListener('keydown', (e) => {
                if (e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase())) ||
                    (e.ctrlKey && ['U', 'S', 'P'].includes(e.key.toUpperCase()))) {
                    e.preventDefault();
                    this.showToast('Akses developer tools tidak diizinkan');
                }
            });
        },

        trackVisibility() {
            document.addEventListener('visibilitychange', () => {
                if (document.hidden && !this.formSubmitted) {
                    this.showWarning = true;
                    this.warningTimer = 10;
                    this.warningInterval = setInterval(() => {
                        this.warningTimer--;
                        if (this.warningTimer <= 0) {
                            clearInterval(this.warningInterval);
                            this.autoSubmit();
                        }
                    }, 1000);
                } else {
                    if (!this.formSubmitted) {
                        this.dismissWarning();
                    }
                }
            });
        },

        trackLeave() {
            window.addEventListener('beforeunload', (e) => {
                if (this.formSubmitted) return;
                this.sendBeacon();
                e.preventDefault();
                e.returnValue = '';
            });
        },

        preventBackNavigation() {
            history.pushState(null, '', location.href);
            window.addEventListener('popstate', (e) => {
                history.pushState(null, '', location.href);
                this.showToast('Tombol kembali dinonaktifkan selama quiz');
            });
        },

        dismissWarning() {
            this.showWarning = false;
            this.warningTimer = 10;
            if (this.warningInterval) {
                clearInterval(this.warningInterval);
                this.warningInterval = null;
            }
        },

        autoSubmit() {
            if (this.formSubmitted) return;
            this.formSubmitted = true;
            this.showWarning = false;
            if (this.warningInterval) {
                clearInterval(this.warningInterval);
            }
            document.getElementById('quiz-form').submit();
        },

        sendBeacon() {
            try {
                const form = document.getElementById('quiz-form');
                const data = new FormData(form);
                data.append('auto_submit', '1');
                navigator.sendBeacon(form.action, data);
            } catch (e) {
                // silently fail
            }
        },

        showToast(message) {
            const container = document.getElementById('cheat-toast');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'px-4 py-2.5 bg-red-500 text-white rounded-xl shadow-lg text-sm font-medium animate-slide-in flex items-center space-x-2';
            toast.innerHTML = '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg><span>' + message + '</span>';
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.transition = 'opacity 0.3s';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    }));
});
</script>
@endpush

@push('styles')
<style>
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
    @@keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endpush