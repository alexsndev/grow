<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100">Gerenciar Credenciais</h1>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($companies as $c)
                <a href="/empresa/{{ $c['slug'] }}/credenciais" class="group relative rounded-xl p-6 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 border border-gray-700/60 hover:border-indigo-500/60 transition shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-gray-100 text-lg group-hover:text-indigo-400">{{ $c['name'] }}</h2>
                        <span class="text-[10px] uppercase tracking-wide px-2 py-1 rounded bg-indigo-600/20 text-indigo-300 border border-indigo-500/30">Acessar</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">Cadastrar, editar e organizar logins e senhas desta empresa.</p>
                    <div class="absolute inset-0 pointer-events-none rounded-xl ring-0 group-hover:ring-2 ring-indigo-500/50 transition" ></div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
