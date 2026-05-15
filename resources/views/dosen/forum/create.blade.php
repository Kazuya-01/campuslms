@extends('layouts.dosen')

@section('title', 'Thread Baru - ' . $class->name . ' - CampusLMS')
@section('page-title', 'Thread Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold">
                {{ substr($class->name, 0, 2) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">Thread Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->name }}</p>
            </div>
        </div>

        <form action="{{ route('dosen.forum.store', $class) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Thread</label>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="255"
                           class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konten</label>
                    <textarea name="content" rows="8" required
                              class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-emerald-500 focus:ring-emerald-500 resize-y">{{ old('content') }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-1" />
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="is_pinned" class="text-sm text-gray-600 dark:text-gray-400">Pin thread ini (selalu di atas)</label>
                </div>
            </div>
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('dosen.forum.class', $class) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl transition-all shadow-sm">
                    Buat Thread
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
