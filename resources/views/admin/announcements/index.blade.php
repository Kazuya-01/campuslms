@extends('layouts.admin')

@section('title', 'Announcements - CampusLMS')
@section('page-title', 'Announcements')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="font-semibold text-gray-900 dark:text-white">All Announcements</h3>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">+ New Announcement</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Title</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">By</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Scope</th>
                <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Date</th>
                <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($announcements as $ann)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-2">
                                @if($ann->is_pinned)<span class="text-xs bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-1.5 py-0.5 rounded">Pinned</span>@endif
                                <span class="font-medium text-gray-800 dark:text-white">{{ $ann->title }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $ann->user?->name }}</td>
                        <td class="px-5 py-3">
                            @if($ann->is_global)<span class="text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 px-2 py-0.5 rounded">Global</span>
                            @else<span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded">{{ $ann->class?->name ?? 'Class' }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $ann->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.announcements.edit', $ann) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No announcements.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($announcements->hasPages())<div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $announcements->links() }}</div>@endif
</div>
@endsection
