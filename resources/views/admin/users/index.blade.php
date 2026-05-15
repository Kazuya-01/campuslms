@extends('layouts.admin')

@section('title', 'Manage Users - CampusLMS')
@section('page-title', 'Manage Users')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="font-semibold text-gray-900 dark:text-white">All Users</h3>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">+ Add User</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">User</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Role</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Joined</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-500 dark:text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-5 py-3">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="w-9 h-9 rounded-full">
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}{{ $user->nim ? ' | ' . $user->nim : '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                    @if($role->name === 'super_admin') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300
                                    @elseif($role->name === 'admin') bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300
                                    @elseif($role->name === 'dosen') bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                                    @else bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300
                                    @endif">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $user->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Edit</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm ml-2">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $users->links() }}</div>
    @endif
</div>
@endsection
