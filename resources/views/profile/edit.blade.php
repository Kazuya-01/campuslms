@php
    $role = auth()->user()->getRoleNames()->first();
    $layout = match ($role) {
        'super_admin', 'admin' => 'layouts.admin',
        'dosen' => 'layouts.dosen',
        default => 'layouts.mahasiswa',
    };
@endphp

@extends($layout)

@section('title', 'Profile - CampusLMS')
@section('page-title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Profile Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="h-24 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500"></div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-12">
                <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-24 h-24 rounded-xl border-4 border-white shadow-lg object-cover">
                <div class="text-center sm:text-left flex-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    <div class="flex items-center justify-center sm:justify-start gap-2 mt-1">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            @switch($role)
                                @case('super_admin') bg-red-100 text-red-700 @break
                                @case('admin') bg-indigo-100 text-indigo-700 @break
                                @case('dosen') bg-emerald-100 text-emerald-700 @break
                                @default bg-blue-100 text-blue-700
                            @endswitch">
                            {{ auth()->user()->role_label }}
                        </span>
                        @if(auth()->user()->username)
                            <span class="text-xs text-gray-400">@ {{ auth()->user()->username }}</span>
                        @endif
                        @if(auth()->user()->nim)
                            <span class="text-xs text-gray-400">NIM: {{ auth()->user()->nim }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Information --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Password --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @include('profile.partials.update-password-form')
    </div>

    {{-- Delete Account --}}
    <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endSection
