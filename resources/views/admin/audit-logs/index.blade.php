@extends('layouts.admin')

@section('title', 'Audit Logs - CampusLMS')
@section('page-title', 'Audit Logs')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Activity Log</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">User</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Action</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">IP</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Time</th>
            </tr></thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="px-5 py-3 text-gray-800 dark:text-white">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-5 py-3"><span class="font-mono text-xs text-gray-600 dark:text-gray-400">{{ $log->action }}</span></td>
                        <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No logs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())<div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $logs->links() }}</div>@endif
</div>
@endsection
