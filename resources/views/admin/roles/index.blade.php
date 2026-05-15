@extends('layouts.admin')

@section('title', 'Roles & Permissions - CampusLMS')
@section('page-title', 'Roles & Permissions')

@section('content')
<div class="space-y-6">
    @foreach($roles as $role)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf @method('PUT')
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">
                        {{ ucfirst($role->name) }}
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">({{ $role->permissions->count() }} permissions)</span>
                    </h3>
                    <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">Save</button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($permissions as $group => $groupPermissions)
                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">{{ $group }}</p>
                            @foreach($groupPermissions as $permission)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    @endforeach
</div>
@endsection
