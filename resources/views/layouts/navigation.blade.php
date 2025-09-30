@php
    $companies = [
        ['slug' => 'feiradasfabricas', 'name' => 'Feira das Fábricas'],
        ['slug' => 'goldbank', 'name' => 'Goldbank'],
        ['slug' => 'ibams', 'name' => 'Ibams'],
    ];
    $isAuthenticated = Auth::check();
    $isAdmin = $isAuthenticated && Auth::user()->email === 'admin@admin.com';
    $navBase = 'backdrop-blur border-b border-indigo-500/40 shadow-sm sticky top-0 z-40';
    $navTheme = $isAdmin
        ? 'bg-white/80 dark:bg-gray-900/70'
        : 'bg-gray-950 text-gray-200';
@endphp

<nav x-data="{ open: false, companyMenu:false }" class="{{ $navBase }} {{ $navTheme }} {{ $isAdmin ? '' : 'client-dark border-indigo-700/60' }}">
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Brand + Primary Links -->
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center group" aria-label="Página inicial Grow">
                    <span class="relative h-9 w-9 inline-flex items-center justify-center">
                        <img src="{{ asset('storage/img/logogrow.webp') }}" alt="Logo Grow" class="h-9 w-9 object-contain select-none" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        <span class="hidden h-9 w-9 rounded-lg bg-gradient-to-br from-indigo-500 via-purple-500 to-blue-500 text-white font-bold text-sm tracking-wider">G</span>
                    </span>
                    <span class="ml-2 font-bold text-lg bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-violet-400 to-blue-400 tracking-tight group-hover:from-indigo-300 group-hover:via-violet-300 group-hover:to-blue-300 drop-shadow">Grow</span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        Início
                    </x-nav-link>
                    @if(!$isAuthenticated)
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">Entrar</x-nav-link>
                    @elseif($isAdmin)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('credentials.hub')" :active="request()->routeIs('credentials.hub')">Credenciais</x-nav-link>
                        <div class="relative" x-data="{open:false}" @mouseleave="open=false">
                            <button @mouseover="open=true" @click="open=!open" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none transition">
                                Empresas
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-cloak x-show="open" x-transition class="absolute mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black/5 p-2 space-y-1">
                                @foreach($companies as $c)
                                    <a href="/empresa/{{ $c['slug'] }}" class="block px-3 py-2 rounded-md text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700/70">Demandas - {{ $c['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @foreach($companies as $c)
                            <div class="relative group">
                                <x-nav-link :href="url('/empresa/'.$c['slug'])" :active="request()->is('empresa/'.$c['slug'])" class="{{ $isAdmin ? '' : 'text-gray-300 hover:text-white dark:text-gray-300 dark:hover:text-white' }}">
                                    {{ $c['name'] }}
                                </x-nav-link>
                                <div class="absolute left-0 mt-1 hidden group-hover:block min-w-[160px] bg-gray-900/95 border border-gray-700 rounded-md py-2 shadow-xl z-50">
                                    <a href="/empresa/{{ $c['slug'] }}" class="block px-4 py-1.5 text-xs text-gray-300 hover:bg-gray-700/60">Demandas</a>
                                    <a href="/empresa/{{ $c['slug'] }}/credenciais" class="block px-4 py-1.5 text-xs text-gray-300 hover:bg-gray-700/60">Credenciais</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Right: User Menu -->
            <div class="hidden sm:flex items-center gap-4">
                @if($isAuthenticated)
                    <div class="flex items-center gap-3 text-xs">
                        @if(!$isAdmin)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Cliente</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300">Admin</span>
                        @endif
                    </div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-gray-800/60 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none transition">
                                <div class="max-w-[140px] truncate">{{ Auth::user()->name }}</div>
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Registrar</a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden hidden border-t border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-900/90 backdrop-blur">
        <div class="px-4 pt-4 pb-3 space-y-2">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">Início</x-responsive-nav-link>
            @if(!$isAuthenticated)
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">Entrar</x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">Registrar</x-responsive-nav-link>
                @endif
            @elseif($isAdmin)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <p class="px-2 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Empresas</p>
                    @foreach($companies as $c)
                        <x-responsive-nav-link :href="url('/empresa/'.$c['slug'])" :active="request()->is('empresa/'.$c['slug'])">Demandas - {{ $c['name'] }}</x-responsive-nav-link>
                    @endforeach
                </div>
            @else
                @foreach($companies as $c)
                    <x-responsive-nav-link :href="url('/empresa/'.$c['slug'])" :active="request()->is('empresa/'.$c['slug'])">{{ $c['name'] }}</x-responsive-nav-link>
                @endforeach
            @endif
        </div>
        @if($isAuthenticated)
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
                <div class="flex flex-col gap-1 mb-3">
                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</span>
                    <span class="inline-flex w-max items-center px-2 py-0.5 mt-1 rounded-full text-[10px] font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ $isAdmin ? 'Admin' : 'Cliente' }}</span>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
