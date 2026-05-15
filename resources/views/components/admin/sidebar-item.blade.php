@props(['href', 'active' => false, 'icon' => null])

<a href="{{ $href }}" @class([
    'flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150',
    'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300' => $active,
    'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' => !$active,
])>
    @if($icon)
        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}" />
        </svg>
    @endif
    {{ $slot }}
</a>
