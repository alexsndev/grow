@php $auth = Auth::check(); @endphp
@if($auth)
    <x-app-layout>
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white min-h-[calc(100vh-4rem)] py-12">
            <div class="w-full max-w-6xl mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-14 tracking-wide">
                    Escolha a empresa para criar tarefas
                </h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <a href="/empresa/feira-das-fabricas" class="group relative bg-gradient-to-br from-purple-600 to-indigo-800 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                        <div class="flex justify-center mb-6">
                            <span class="bg-purple-500 p-4 rounded-full shadow-lg group-hover:bg-indigo-600 transition flex items-center justify-center w-32 h-32">
                                <img src="{{ asset('storage/img/logofeiradasfabricas.svg') }}" alt="Feira das Fábricas" class="max-h-24 object-contain drop-shadow-lg">
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">Feira das Fábricas</h2>
                        <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                        <span class="absolute bottom-4 right-4 text-xs text-purple-200 opacity-70">Empresa #1</span>
                    </a>
                    <a href="/empresa/goldbank" class="group relative bg-gradient-to-br from-yellow-500 to-orange-700 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                        <div class="flex justify-center mb-6">
                            <span class="bg-yellow-400 p-4 rounded-full shadow-lg group-hover:bg-orange-600 transition flex items-center justify-center w-32 h-32">
                                <img src="{{ asset('storage/img/logo%20goldbank.png') }}" alt="Goldbank" class="max-h-24 object-contain drop-shadow-lg">
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">Goldbank</h2>
                        <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                        <span class="absolute bottom-4 right-4 text-xs text-yellow-200 opacity-70">Empresa #2</span>
                    </a>
                    <a href="/empresa/ibams" class="group relative bg-gradient-to-br from-green-600 to-emerald-800 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                        <div class="flex justify-center mb-6">
                            <span class="bg-green-500 p-4 rounded-full shadow-lg group-hover:bg-emerald-700 transition flex items-center justify-center w-32 h-32">
                                <img src="{{ asset('storage/img/logoibams.webp') }}" alt="Ibams" class="max-h-24 object-contain drop-shadow-lg">
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">Ibams</h2>
                        <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                        <span class="absolute bottom-4 right-4 text-xs text-green-200 opacity-70">Empresa #3</span>
                    </a>
                </div>
            </div>
        </div>
    </x-app-layout>
@else
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Empresas - Criar Tarefas</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <style> body { font-family: 'Inter', sans-serif; } </style>
    </head>
    <body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white min-h-screen flex items-center justify-center">
        <div class="w-full max-w-6xl px-6">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-14 tracking-wide">Escolha a empresa para criar tarefas</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <a href="/empresa/feira-das-fabricas" class="group relative bg-gradient-to-br from-purple-600 to-indigo-800 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <div class="flex justify-center mb-6">
                        <span class="bg-purple-500 p-4 rounded-full shadow-lg group-hover:bg-indigo-600 transition flex items-center justify-center w-32 h-32">
                            <img src="{{ asset('storage/img/logofeiradasfabricas.svg') }}" alt="Feira das Fábricas" class="max-h-24 object-contain drop-shadow-lg">
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Feira das Fábricas</h2>
                    <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                    <span class="absolute bottom-4 right-4 text-xs text-purple-200 opacity-70">Empresa #1</span>
                </a>
                <a href="/empresa/goldbank" class="group relative bg-gradient-to-br from-yellow-500 to-orange-700 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <div class="flex justify-center mb-6">
                        <span class="bg-yellow-400 p-4 rounded-full shadow-lg group-hover:bg-orange-600 transition flex items-center justify-center w-32 h-32">
                            <img src="{{ asset('storage/img/logo%20goldbank.png') }}" alt="Goldbank" class="max-h-24 object-contain drop-shadow-lg">
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Goldbank</h2>
                    <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                    <span class="absolute bottom-4 right-4 text-xs text-yellow-200 opacity-70">Empresa #2</span>
                </a>
                <a href="/empresa/ibams" class="group relative bg-gradient-to-br from-green-600 to-emerald-800 rounded-2xl shadow-lg p-10 text-center hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <div class="flex justify-center mb-6">
                        <span class="bg-green-500 p-4 rounded-full shadow-lg group-hover:bg-emerald-700 transition flex items-center justify-center w-32 h-32">
                            <img src="{{ asset('storage/img/logoibams.webp') }}" alt="Ibams" class="max-h-24 object-contain drop-shadow-lg">
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Ibams</h2>
                    <p class="text-gray-300">Clique para criar tarefas para esta empresa</p>
                    <span class="absolute bottom-4 right-4 text-xs text-green-200 opacity-70">Empresa #3</span>
                </a>
            </div>
            <div class="mt-12 flex flex-col md:flex-row justify-between items-center text-gray-400 text-sm">
                <div class="flex items-center space-x-4">
                    <a href="https://laravel.bigcartel.com" class="hover:text-white transition">🛒 Shop</a>
                    <a href="https://github.com/sponsors/taylorotwell" class="hover:text-white transition">❤️ Sponsor</a>
                </div>
                <div class="mt-4 md:mt-0">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
            </div>
        </div>
    </body>
    </html>
@endif
