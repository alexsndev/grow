@props(['active'])

@php
    $isAdmin = Auth::check() && Auth::user()->email === 'admin@admin.com';
    if ($isAdmin) {
        $classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-500 dark:border-indigo-600 text-left text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/40 focus:outline-none transition'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition';
    } else {
        $classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-left text-base font-medium text-indigo-300 bg-gray-900 focus:outline-none transition'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-300/90 hover:text-white hover:bg-gray-800 hover:border-indigo-500/50 focus:outline-none transition';
    }
@endphp

<a {{ $attributes->merge(['class' => 'responsive-nav-link '.$classes]) }}>
    {{ $slot }}
</a>
