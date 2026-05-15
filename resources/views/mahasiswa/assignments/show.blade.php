@extends('layouts.mahasiswa')

@section('title', $assignment->title . ' - CampusLMS')
@section('page-title', $assignment->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('mahasiswa.assignments.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">&larr; Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            {{-- Detail Tugas --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $assignment->title }}</h2>
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        @if($submission && $submission->score !== null) bg-green-100 dark:bg-green-900/30 text-green-700
                        @elseif($submission) bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700
                        @elseif($assignment->deadline && $assignment->deadline->isPast()) bg-red-100 dark:bg-red-900/30 text-red-700
                        @else bg-blue-100 dark:bg-blue-900/30 text-blue-700
                        @endif">
                        @if($submission && $submission->score !== null) Selesai Dinilai
                        @elseif($submission) Sudah Dikumpulkan
                        @elseif($assignment->deadline && $assignment->deadline->isPast()) Terlambat
                        @else Belum Dikerjakan
                        @endif
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Kelas</span>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $class->name }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Nilai Maksimal</span>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $assignment->max_score }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Deadline</span>
                        <p class="font-medium {{ $assignment->deadline && $assignment->deadline->isPast() ? 'text-red-600' : 'text-gray-800 dark:text-white' }}">
                            {{ $assignment->deadline?->format('d M Y H:i') ?? 'Tidak ada' }}
                        </p>
                    </div>
                </div>

                @if($assignment->description)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-1">Deskripsi</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $assignment->description }}</p>
                    </div>
                @endif

                @if($assignment->instructions)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-1">Instruksi</h4>
                        <div class="text-gray-600 dark:text-gray-400 text-sm">{{ $assignment->instructions }}</div>
                    </div>
                @endif

                @if($assignment->file_path)
                    <a href="{{ $assignment->file_url }}" target="_blank" class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-200 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download Lampiran Tugas</span>
                    </a>
                @endif
            </div>

            {{-- Form Pengumpulan --}}
            @if(!$submission || (!$submission->score && $submission->status !== 'graded'))
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Kumpulkan Tugas</h3>
                    <form action="{{ route('mahasiswa.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">File Tugas</label>
                                <input type="file" name="file" required class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100">
                                @error('file')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (opsional)</label>
                                <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm" placeholder="Tambahkan catatan untuk dosen...">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm">
                                Kumpulkan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            @if($submission)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Pengumpulan Kamu</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Status</span>
                            <span class="font-medium {{ $submission->status === 'graded' ? 'text-green-600' : ($submission->status === 'late' ? 'text-red-600' : 'text-yellow-600') }}">
                                {{ $submission->status_label }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Dikumpulkan</span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $submission->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($submission->score !== null)
                            <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400 font-medium">Nilai</span>
                                <span class="font-bold text-lg text-blue-600 dark:text-blue-400">{{ $submission->score }}/{{ $assignment->max_score }}</span>
                            </div>
                        @endif
                        @if($submission->notes)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Catatan:</span>
                                <p class="text-gray-800 dark:text-white mt-1">{{ $submission->notes }}</p>
                            </div>
                        @endif
                        @if($submission->feedback)
                            <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400">Feedback Dosen:</span>
                                <p class="text-gray-800 dark:text-white mt-1">{{ $submission->feedback }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
