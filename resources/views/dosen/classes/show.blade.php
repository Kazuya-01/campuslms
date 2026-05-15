@extends('layouts.dosen')

@section('title', $class->name . ' - CampusLMS')
@section('page-title', $class->name)

@section('content')
<div class="space-y-6">
    {{-- Class Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="h-40 bg-gradient-to-br from-emerald-500 to-teal-600 relative flex items-end p-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ substr($class->name, 0, 2) }}</span>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $class->name }}</h2>
                    <p class="text-emerald-100 text-sm">Code: <span class="font-mono font-bold">{{ $class->code }}</span></p>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700">
            <span>{{ $class->students_count }} Mahasiswa</span>
            <span>{{ $class->materials_count }} Materi</span>
            <span>{{ $class->assignments_count }} Tugas</span>
            <span>{{ $class->quizzes_count ?? 0 }} Quiz</span>
            <a href="{{ route('dosen.classes.edit', $class->slug) }}" class="ml-auto text-emerald-600 dark:text-emerald-400 hover:underline">Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Materials --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Materi Pembelajaran</h3>
                    <a href="{{ route('dosen.classes.materials.create', $class) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline">+ Add Material</a>
                </div>
                <div class="space-y-2">
                    @forelse($class->materials as $material)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <div class="flex items-center space-x-3">
                                @if($material->type === 'file')
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @elseif($material->type === 'video')
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $material->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pertemuan {{ $material->meeting_number ?? '-' }} &bull; {{ ucfirst($material->type) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('dosen.materials.edit', $material) }}" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline">Edit</a>
                                <form action="{{ route('dosen.materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada materi. Tambahkan materi pertama Anda.</p>
                    @endforelse
                </div>
            </div>

            {{-- Assignments --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Tugas</h3>
                    <a href="{{ route('dosen.assignments.create', ['class_id' => $class->id]) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline">+ Add Assignment</a>
                </div>
                <div class="space-y-2">
                    @forelse($class->assignments as $assignment)
                        <a href="{{ route('dosen.assignments.show', $assignment) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $assignment->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Deadline: {{ $assignment->deadline?->format('M d, Y H:i') ?? 'No deadline' }} &bull; {{ $assignment->submissions->count() }} submissions</p>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $assignment->status === 'open' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                {{ $assignment->status === 'open' ? 'Open' : 'Closed' }}
                            </span>
                        </a>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm py-4 text-center">Belum ada tugas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Students Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Peserta ({{ $class->students_count }})</h3>
                    <a href="{{ route('dosen.classes.students', $class) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    @foreach($class->students->take(5) as $student)
                        <div class="flex items-center space-x-3">
                            <img src="{{ $student->avatar_url }}" alt="" class="w-8 h-8 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Progress: {{ $student->pivot->progress }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('dosen.classes.materials.create', $class) }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">+ Tambah Materi</a>
                    <a href="{{ route('dosen.assignments.create', ['class_id' => $class->id]) }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">+ Buat Tugas</a>
                    <a href="{{ route('dosen.quizzes.create', ['class_id' => $class->id]) }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">+ Buat Quiz</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
