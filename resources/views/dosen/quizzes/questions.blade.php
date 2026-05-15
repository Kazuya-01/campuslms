@extends('layouts.dosen')

@section('title', 'Quiz Questions - CampusLMS')
@section('page-title', 'Manage Questions: ' . $quiz->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Question List --}}
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Questions ({{ $quiz->questions->count() }})</h3>
            @forelse($quiz->questions as $index => $q)
                <div class="p-4 rounded-lg border border-gray-100 dark:border-gray-700 mb-3 last:mb-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $q->type === 'multiple_choice' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">{{ $q->type_label }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $q->points }} pts</span>
                            </div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $index + 1 }}. {{ $q->question }}</p>
                            @if($q->type === 'multiple_choice' && $q->options)
                                @php $isAssoc = is_array($q->options[0] ?? null); @endphp
                                <div class="mt-2 space-y-1">
                                    @foreach($q->options as $key => $opt)
                                        @php
                                            if ($isAssoc) {
                                                $letter = $opt['value'];
                                                $label = $opt['label'];
                                                $correct = $opt['value'] === $q->correct_answer;
                                            } else {
                                                $letter = chr(65 + (int)$key);
                                                $label = $opt;
                                                $correct = (string)$key === (string)$q->correct_answer;
                                            }
                                        @endphp
                                        <p class="text-xs {{ $correct ? 'text-green-600 dark:text-green-400 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $letter }}. {{ $label }} {{ $correct ? '✓' : '' }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('dosen.quizzes.questions.destroy', [$quiz, $q]) }}" method="POST" class="ml-2" onsubmit="return confirm('Delete question?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-xs">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada pertanyaan.</p>
            @endforelse
        </div>
    </div>

    {{-- Add Question --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 h-fit">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tambah Pertanyaan</h3>
        <form action="{{ route('dosen.quizzes.questions.store', $quiz) }}" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe</label>
                    <select name="type" id="q-type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                        <option value="multiple_choice">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Pertanyaan</label>
                    <textarea name="question" rows="2" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"></textarea>
                </div>
                <div id="mc-options">
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Options (A-D)</label>
                    @foreach(['A', 'B', 'C', 'D'] as $letter)
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-xs font-medium text-gray-500 w-4">{{ $letter }}.</span>
                            <input type="text" name="options[]" placeholder="Option {{ $letter }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                        </div>
                    @endforeach
                    <div class="mt-2">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Correct Answer</label>
                        <select name="correct_answer" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="0">A</option>
                            <option value="1">B</option>
                            <option value="2">C</option>
                            <option value="3">D</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Points</label>
                    <input type="number" name="points" value="10" min="0" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg">Add Question</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('q-type').addEventListener('change', function() {
        document.getElementById('mc-options').classList.toggle('hidden', this.value !== 'multiple_choice');
    });
</script>
@endpush
@endsection
