@extends('layouts.mahasiswa')

@section('title', $material->title . ' - CampusLMS')
@section('page-title', $material->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-4">
            <a href="{{ route('mahasiswa.classes.show', $class->slug) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">&larr; Kembali ke Kelas</a>
        </div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $material->title }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pertemuan {{ $material->meeting_number ?? '-' }} &bull; {{ ucfirst($material->type) }}</p>
            </div>
            @if($isCompleted)
                <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-medium rounded-lg flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Selesai</span>
                </span>
            @else
                <form action="{{ route('mahasiswa.classes.materials.mark', [$class->slug, $material]) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">Tandai Selesai</button>
                </form>
            @endif
        </div>

        @if($material->description)
            <div class="mb-6 text-gray-600 dark:text-gray-400 text-sm">{{ $material->description }}</div>
        @endif

        @if($material->type === 'file' && $material->file_path)
            <div class="flex items-center justify-center h-96 bg-gray-100 dark:bg-gray-700 rounded-lg">
                @if(in_array($material->file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <img src="{{ $material->file_url }}" alt="{{ $material->title }}" class="max-h-full object-contain">
                @elseif($material->file_type === 'pdf')
                    <iframe src="{{ $material->file_url }}" class="w-full h-full rounded-lg" frameborder="0"></iframe>
                @else
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">{{ $material->file_size_formatted }}</p>
                        <a href="{{ $material->file_url }}" download class="mt-3 inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">Download File</a>
                    </div>
                @endif
            </div>
        @elseif($material->type === 'video')
            <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                @if($material->video_url)
                    <iframe src="{{ $material->video_url }}" class="w-full h-96 rounded-lg" allowfullscreen></iframe>
                @endif
            </div>
        @elseif($material->type === 'link' && $material->link_url)
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <a href="{{ $material->link_url }}" target="_blank" class="mt-3 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">Buka Link</a>
            </div>
        @endif
    </div>
</div>
@endsection
