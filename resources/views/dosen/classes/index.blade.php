@extends('layouts.dosen')

@section('title', 'My Classes - CampusLMS')
@section('page-title', 'My Classes')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('dosen.classes.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg">+ New Class</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($classes as $class)
        <a href="{{ route('dosen.classes.show', $class->slug) }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md hover:border-emerald-300 dark:hover:border-emerald-600 transition-all overflow-hidden">
            <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative">
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-white text-4xl font-bold opacity-30">{{ substr($class->name, 0, 2) }}</span>
                </div>
                <div class="absolute bottom-3 left-3">
                    <span class="px-2 py-0.5 bg-white/20 text-white text-xs rounded-full">{{ $class->code }}</span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $class->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $class->category ?? 'General' }} {{ $class->level ? '| ' . $class->level : '' }}</p>
                <div class="flex items-center justify-between mt-3 text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $class->students_count }} Students</span>
                    <span>{{ $class->materials_count }} Materials</span>
                    <span>{{ $class->assignments_count }} Assignments</span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <p class="text-lg font-medium">Belum ada kelas</p>
            <p class="text-sm mt-1">Buat kelas baru untuk memulai pembelajaran.</p>
        </div>
    @endforelse
</div>
@if($classes->hasPages())<div class="mt-4">{{ $classes->links() }}</div>@endif
@endsection
