<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#4f46e5" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/icons/icon-192.png" />
    <meta name="mobile-web-app-capable" content="yes">
    <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div id="pwa-update-banner" class="hidden fixed bottom-4 left-4 z-50 max-w-xs w-full bg-indigo-600 text-white border border-indigo-400/40 rounded-xl shadow-lg p-4 backdrop-blur-md">
            <div class="flex flex-col gap-2 text-sm">
                <span>Uma nova versão está disponível.</span>
                <div class="flex gap-2">
                    <button id="pwa-reload-btn" class="px-3 py-1.5 rounded bg-white/15 hover:bg-white/25 text-white text-xs font-medium">Atualizar</button>
                    <button id="pwa-reload-dismiss" class="px-3 py-1.5 rounded bg-white/5 hover:bg-white/15 text-white/80 text-xs">Depois</button>
                </div>
            </div>
        </div>
        @php
            $isLogin = request()->routeIs('login');
        @endphp
        @if($isLogin)
            <div class="login-bg">
                <div class="login-card">
                    {{ $slot }}
                </div>
            </div>
        @else
            @include('layouts.navigation')
            <main class="min-h-screen bg-gray-100 dark:bg-gray-900">
                <div class="max-w-6xl mx-auto px-4 py-10">
                    {{ $slot }}
                </div>
            </main>
        @endif
    </body>
</html>
