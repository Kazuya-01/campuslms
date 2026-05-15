@extends('layouts.dosen')

@section('title', 'Edit Material - CampusLMS')
@section('page-title', 'Edit Materi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('dosen.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Materi</label>
                    <input type="text" name="title" value="{{ old('title', $material->title) }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description', $material->description) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Materi</label>
                        <select name="type" id="material-type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="file" {{ $material->type === 'file' ? 'selected' : '' }}>File</option>
                            <option value="video" {{ $material->type === 'video' ? 'selected' : '' }}>Video</option>
                            <option value="link" {{ $material->type === 'link' ? 'selected' : '' }}>Link</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pertemuan</label>
                        <input type="number" name="meeting_number" value="{{ old('meeting_number', $material->meeting_number) }}" min="1" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div id="file-upload" class="{{ $material->type !== 'file' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">File</label>
                    <input type="file" name="file_path" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700">
                </div>
                <div id="video-url" class="{{ $material->type !== 'video' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Video URL</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $material->video_url) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div id="link-url" class="{{ $material->type !== 'link' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Link URL</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $material->link_url) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('dosen.classes.show', $class->slug) }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('material-type').addEventListener('change', function() {
        document.getElementById('file-upload').classList.toggle('hidden', this.value !== 'file');
        document.getElementById('video-url').classList.toggle('hidden', this.value !== 'video');
        document.getElementById('link-url').classList.toggle('hidden', this.value !== 'link');
    });
</script>
@endpush
@endsection
