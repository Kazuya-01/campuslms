@extends('layouts.mahasiswa')

@section('title', 'My Certificates - CampusLMS')
@section('page-title', 'Sertifikat Saya')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($certificates as $certificate)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition-all">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $certificate->class?->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $certificate->certificate_number }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Issued: {{ $certificate->issued_at?->format('M d, Y') ?? $certificate->created_at->format('M d, Y') }}</p>
                <a href="{{ route('mahasiswa.certificates.download', $certificate) }}" class="mt-4 inline-block px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-lg">Download PDF</a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
            <p class="text-lg font-medium">Belum ada sertifikat</p>
            <p class="text-sm mt-1">Selesaikan kelas untuk mendapatkan sertifikat.</p>
        </div>
    @endforelse
</div>
@if($certificates->hasPages())<div class="mt-4">{{ $certificates->links() }}</div>@endif
@endsection
