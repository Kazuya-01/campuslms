@extends('layouts.dosen')

@section('title', 'Sertifikat - CampusLMS')
@section('page-title', 'Sertifikat')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('dosen.certificates.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg">+ Terbitkan Sertifikat</a>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Mahasiswa</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Kelas</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">No. Sertifikat</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Diterbitkan</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($certificates as $c)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $c->user?->avatar_url }}" alt="" class="w-7 h-7 rounded-full">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $c->user?->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $c->class?->name }}</td>
                        <td class="px-5 py-3 font-mono text-xs text-gray-500 dark:text-gray-400">{{ $c->certificate_number }}</td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">{{ ($c->issued_at ?? $c->created_at)->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('dosen.certificates.download', $c) }}" class="text-emerald-600 dark:text-emerald-400 hover:underline text-sm">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada sertifikat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($certificates->hasPages())<div class="p-5 border-t">{{ $certificates->links() }}</div>@endif
</div>
@endsection
