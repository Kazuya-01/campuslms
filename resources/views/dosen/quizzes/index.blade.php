@extends('layouts.dosen')

@section('title', 'Quizzes - CampusLMS')
@section('page-title', 'My Quizzes')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('dosen.quizzes.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg">+ New Quiz</a>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Quiz</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Class</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Questions</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Time Limit</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($quizzes as $quiz)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3 font-medium text-gray-800 dark:text-white">{{ $quiz->title }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $quiz->class?->name }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $quiz->questions->count() }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $quiz->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('dosen.quizzes.questions', $quiz) }}" class="text-emerald-600 dark:text-emerald-400 hover:underline text-sm">Questions</a>
                            <form action="{{ route('dosen.quizzes.toggle', $quiz) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm ml-2">{{ $quiz->is_active ? 'Deactivate' : 'Activate' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No quizzes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($quizzes->hasPages())<div class="p-5 border-t">{{ $quizzes->links() }}</div>@endif
</div>
@endsection
