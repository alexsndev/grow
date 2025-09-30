@props(['active'])

@php
    $isAdmin = Auth::check() && Auth::user()->email === 'admin@admin.com';
    if ($isAdmin) {
        $classes = ($active ?? false)
            ? 'inline-flex items-center px-2 pt-1 border-b-2 border-indigo-500 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition'
            : 'inline-flex items-center px-2 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none transition';
    } else {
        // Client dark variant: higher contrast on dark solid header
        $classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1 h-10 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-indigo-300 hover:text-indigo-200 focus:outline-none transition'
            : 'inline-flex items-center px-3 pt-1 h-10 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300/90 hover:text-white hover:border-indigo-500/50 focus:outline-none transition';
    }
@endphp

<a {{ $attributes->merge(['class' => 'nav-link '.$classes]) }}>
    {{ $slot }}
</a>
