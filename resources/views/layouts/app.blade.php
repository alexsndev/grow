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

        <!-- PWA Meta -->
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#4f46e5" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="apple-touch-icon" href="/icons/icon-192.png" />
        <meta name="mobile-web-app-capable" content="yes">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div id="pwa-update-banner" class="hidden fixed bottom-4 left-4 z-50 max-w-xs w-full bg-indigo-600 text-white border border-indigo-400/40 rounded-xl shadow-lg p-4 backdrop-blur-md">
                <div class="flex flex-col gap-2 text-sm">
                    <span>Uma nova versão está disponível.</span>
                    <div class="flex gap-2">
                        <button id="pwa-reload-btn" class="px-3 py-1.5 rounded bg-white/15 hover:bg-white/25 text-white text-xs font-medium">Atualizar</button>
                        <button id="pwa-reload-dismiss" class="px-3 py-1.5 rounded bg-white/5 hover:bg-white/15 text-white/80 text-xs">Depois</button>
                    </div>
                </div>
            </div>
            <div id="pwa-install-banner" class="hidden fixed bottom-4 right-4 z-50 max-w-xs w-full bg-gray-900 text-gray-100 border border-indigo-500/40 rounded-xl shadow-lg p-4 backdrop-blur-md">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <img src="/icons/icon-192.png" onerror="this.style.display='none'" class="h-10 w-10 rounded" alt="App" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-sm">Instalar aplicativo</h3>
                        <p class="text-xs text-gray-300 leading-relaxed">Acesse mais rápido: adicione o portal à sua tela inicial.</p>
                        <div class="mt-3 flex gap-2">
                            <button id="pwa-install-btn" class="px-3 py-1.5 rounded bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-medium">Instalar</button>
                            <button id="pwa-dismiss-btn" class="px-3 py-1.5 rounded bg-gray-700 hover:bg-gray-600 text-xs">Agora não</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
