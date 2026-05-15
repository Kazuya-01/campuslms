@extends('layouts.dosen')

@section('title', 'Students - ' . $class->name)
@section('page-title', 'Peserta Kelas: ' . $class->name)

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $students->total() }} Mahasiswa Terdaftar</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Mahasiswa</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">NIM</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Progress</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Bergabung</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $student->avatar_url }}" alt="" class="w-8 h-8 rounded-full">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $student->nim ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $student->pivot->progress }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $student->pivot->progress }}%</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $student->pivot->created_at?->format('M d, Y') ?? '-' }}</td>
                        <td class="px-5 py-3 text-right">
                            <form action="{{ route('dosen.classes.students.remove', [$class, $student->id]) }}" method="POST" onsubmit="return confirm('Hapus mahasiswa ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:underline">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())<div class="p-5 border-t">{{ $students->links() }}</div>@endif
</div>
@endsection
