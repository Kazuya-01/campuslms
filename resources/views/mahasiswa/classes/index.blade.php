@extends('layouts.mahasiswa')

@section('title', 'My Classes - CampusLMS')
@section('page-title', 'My Classes')

@section('content')
<div class="space-y-6">
    {{-- Join Class --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('mahasiswa.classes.join') }}" method="POST" class="flex items-center space-x-3">
            @csrf
            <div class="flex-1">
                <input type="text" name="code" placeholder="Enter class code..." required maxlength="6" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white uppercase" style="letter-spacing: 3px; font-size: 1.1rem;">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">Join Class</button>
        </form>
    </div>

    {{-- Enrolled Classes --}}
    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">Kelas Saya</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($classes as $class)
            <a href="{{ route('mahasiswa.classes.show', $class->slug) }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-600 transition-all overflow-hidden">
                <div class="h-32 bg-gradient-to-br from-blue-500 to-cyan-600 relative flex items-end p-4">
                    <div>
                        <h3 class="text-white font-bold text-lg">{{ $class->name }}</h3>
                        <p class="text-blue-100 text-xs">{{ $class->dosen?->name }}</p>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="text-gray-500 dark:text-gray-400">Progress</span>
                        <span class="font-medium text-gray-800 dark:text-white">{{ $class->pivot->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2 rounded-full transition-all duration-700" style="width: {{ $class->pivot->progress }}%"></div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                <p class="text-lg font-medium">Belum ada kelas</p>
                <p class="text-sm mt-1">Gunakan kode kelas dari dosen Anda untuk bergabung.</p>
            </div>
        @endforelse
    </div>

    {{-- Available Classes --}}
    @if($availableClasses->count() > 0)
        <h3 class="font-semibold text-gray-900 dark:text-white text-lg mt-8">Kelas Tersedia</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($availableClasses as $class)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-bold">{{ substr($class->name, 0, 2) }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-white truncate">{{ $class->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->dosen?->name }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Code: {{ $class->code }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
