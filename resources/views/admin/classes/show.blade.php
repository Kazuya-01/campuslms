@extends('layouts.admin')

@section('title', $class->name . ' - CampusLMS')
@section('page-title', $class->name)

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-end p-6">
            <div class="flex items-center space-x-4 text-white">
                <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <span class="text-2xl font-bold">{{ substr($class->name, 0, 2) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $class->name }}</h2>
                    <p class="text-indigo-200 text-sm">Code: {{ $class->code }} &bull; Dosen: {{ $class->dosen?->name }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-3 flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 border-t">
            <span>{{ $class->students_count }} Students</span>
            <span>{{ $class->materials->count() }} Materials</span>
            <span>{{ $class->assignments->count() }} Assignments</span>
            <span class="px-2 py-0.5 rounded-full {{ $class->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">{{ $class->is_active ? 'Active' : 'Inactive' }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Deskripsi</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $class->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500 dark:text-gray-400">Kategori:</span> <span class="font-medium text-gray-800 dark:text-white">{{ $class->category ?? '-' }}</span></div>
                    <div><span class="text-gray-500 dark:text-gray-400">Level:</span> <span class="font-medium text-gray-800 dark:text-white">{{ $class->level ?? '-' }}</span></div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Materi ({{ $class->materials->count() }})</h3>
                @forelse($class->materials as $material)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <span class="text-sm text-gray-800 dark:text-white">{{ $material->title }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($material->type) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada materi.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Peserta ({{ $class->students->count() }})</h3>
                @forelse($class->students as $student)
                    <div class="flex items-center space-x-2 py-1.5">
                        <img src="{{ $student->avatar_url }}" alt="" class="w-6 h-6 rounded-full">
                        <span class="text-sm text-gray-800 dark:text-white">{{ $student->name }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada peserta.</p>
                @endforelse
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Aksi</h3>
                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg">Hapus Kelas</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
