@extends('layouts.dosen')

@section('title', 'Assignments - CampusLMS')
@section('page-title', 'All Assignments')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('dosen.assignments.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg">+ New Assignment</a>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Assignment</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Class</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Deadline</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Submissions</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($assignments as $assignment)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3 font-medium text-gray-800 dark:text-white">{{ $assignment->title }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $assignment->class?->name }}</td>
                        <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $assignment->deadline?->format('M d, Y H:i') ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $assignment->submissions->count() }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $assignment->status === 'open' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                {{ $assignment->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('dosen.assignments.show', $assignment) }}" class="text-emerald-600 dark:text-emerald-400 hover:underline text-sm">View</a>
                            <a href="{{ route('dosen.assignments.edit', $assignment) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm ml-2">Edit</a>
                            <form action="{{ route('dosen.assignments.destroy', $assignment) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini? Semua pengumpulan mahasiswa juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())<div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $assignments->links() }}</div>@endif
</div>
@endsection
