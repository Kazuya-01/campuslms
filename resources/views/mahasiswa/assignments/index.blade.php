@extends('layouts.mahasiswa')

@section('title', 'Tugas Saya - CampusLMS')
@section('page-title', 'Tugas Saya')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Tugas</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Kelas</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Deadline</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Nilai</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($assignments as $assignment)
                    @php
                        $sub = $assignment->submissions?->first();
                    @endphp
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3 font-medium text-gray-800 dark:text-white">{{ $assignment->title }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $assignment->class?->name }}</td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $assignment->deadline?->format('d M Y, H:i') ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($sub && $sub->score !== null)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Dinilai</span>
                            @elseif($sub)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300">Dikumpulkan</span>
                            @elseif($assignment->deadline && $assignment->deadline->isPast())
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">Terlambat</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">Belum</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-800 dark:text-white">{{ $sub && $sub->score !== null ? $sub->score . '/' . $assignment->max_score : '-' }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('mahasiswa.assignments.show', $assignment) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())<div class="p-5 border-t">{{ $assignments->links() }}</div>@endif
</div>
@endsection
