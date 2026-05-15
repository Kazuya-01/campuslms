@extends('layouts.admin')

@section('title', 'Notifications - CampusLMS')
@section('page-title', 'Notifications')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">All Notifications</h3>
    </div>
    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($notifications as $notification)
            <div class="px-5 py-4 {{ !$notification->is_read ? 'bg-indigo-50 dark:bg-indigo-900/10' : '' }}">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $notification->title }}</p>
                        @if($notification->message)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-0.5">{{ $notification->message }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notification->is_read)
                        <span class="w-2 h-2 bg-indigo-500 rounded-full flex-shrink-0 mt-2"></span>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-5 py-12 text-center text-gray-500 dark:text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <p class="text-sm font-medium">No notifications</p>
            </div>
        @endforelse
    </div>
    @if($notifications->hasPages())
        <div class="p-5 border-t border-gray-200 dark:border-gray-700">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
