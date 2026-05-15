@extends('layouts.admin')

@section('title', 'Manage Classes - CampusLMS')
@section('page-title', 'All Classes')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Classes ({{ $classes->total() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Class</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Dosen</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Code</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Students</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">{{ substr($class->name, 0, 2) }}</div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $class->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->category ?? 'N/A' }} {{ $class->level ? '| ' . $class->level : '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $class->dosen?->name ?? 'N/A' }}</td>
                        <td class="px-5 py-3"><span class="font-mono text-indigo-600 dark:text-indigo-400 font-medium">{{ $class->code }}</span></td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $class->students_count }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $class->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                {{ $class->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.classes.show', $class) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">View</a>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Delete this class?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No classes found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($classes->hasPages())<div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $classes->links() }}</div>@endif
</div>
@endsection
