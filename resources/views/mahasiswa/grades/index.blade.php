@extends('layouts.mahasiswa')

@section('title', 'Nilai Saya - CampusLMS')
@section('page-title', 'Nilai Saya')

@section('content')
<div class="space-y-6">
    @forelse($allGrades as $classId => $grades)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">{{ $grades->first()['class_name'] ?? 'Kelas' }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <th class="text-left px-4 py-2 font-medium text-gray-500 dark:text-gray-400">Nama</th>
                            <th class="text-left px-4 py-2 font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                            <th class="text-left px-4 py-2 font-medium text-gray-500 dark:text-gray-400">Nilai</th>
                            <th class="text-left px-4 py-2 font-medium text-gray-500 dark:text-gray-400">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-2 text-gray-800 dark:text-white font-medium">{{ $grade['title'] }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                        @if($grade['type'] === 'assignment' || $grade['type_label'] === 'Tugas') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300
                                        @elseif($grade['type'] === 'quiz' || $grade['type_label'] === 'Quiz') bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                                        @endif">
                                        {{ $grade['type_label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 font-semibold text-gray-800 dark:text-white">{{ $grade['score'] }}/{{ $grade['max_score'] }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $grade['percentage'] >= 70 ? 'bg-gradient-to-r from-blue-500 to-cyan-500' : 'bg-gradient-to-r from-red-500 to-orange-500' }}" style="width: {{ $grade['percentage'] }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium {{ $grade['percentage'] >= 70 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ number_format($grade['percentage'], 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <p class="text-lg font-medium">Belum ada nilai</p>
            <p class="text-sm mt-1">Nilai akan muncul setelah dosen memberikan penilaian.</p>
        </div>
    @endforelse
</div>
@endsection
