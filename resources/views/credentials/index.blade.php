<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4" x-data="{ show: {} }">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Credenciais - <span class="text-indigo-500">{{ ucfirst(str_replace('-', ' ', $slug)) }}</span></h1>

    <x-company-tabs :slug="$slug" active="credentials" :demands-count="$demandsCount" :credentials-count="$creds->count()" />

    @if(session('success'))
            <div class="mb-6 rounded-md border border-green-600/30 bg-green-600/10 px-4 py-3 text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-md border border-red-600/40 bg-red-600/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($isAdmin)
            <div class="mb-10 bg-white dark:bg-gray-800 shadow rounded-lg p-6" x-data="{open:true}">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Adicionar credencial</h2>
                    <button @click="open=!open" class="text-xs px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">@{{ open ? 'Fechar' : 'Abrir' }}</button>
                </div>
                <form x-show="open" x-transition method="POST" action="{{ route('empresa.credentials.store', $slug) }}" class="grid gap-4 md:grid-cols-3" autocomplete="off">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 mb-1">Categoria</label>
                        <input name="category" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm" placeholder="Ex: ERP">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 mb-1">Rótulo</label>
                        <input name="label" required class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm" placeholder="Painel Financeiro">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 mb-1">Usuário / Email</label>
                        <input name="username" required class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 mb-1">Senha</label>
                        <input name="password" required type="text" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 mb-1">Notas (opcional)</label>
                        <input name="notes" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 px-3 py-2 text-sm" placeholder="Observações">
                    </div>
                    <div class="md:col-span-3 flex justify-end">
                        <button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">Salvar</button>
                    </div>
                </form>
            </div>
        @endif

        @php
            $grouped = $creds->groupBy(fn($c) => $c->category ?? 'Sem categoria');
        @endphp

        <div class="space-y-10">
            @forelse($grouped as $category => $items)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200 text-sm uppercase tracking-wide">{{ $category }}</h3>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ $items->count() }} credenciais</span>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($items as $cred)
                            <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="font-medium text-gray-800 dark:text-gray-100">{{ $cred->label }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded bg-indigo-500/15 text-indigo-600 dark:text-indigo-300 border border-indigo-500/30 font-medium">{{ $cred->username }}</span>
                                    </div>
                                    @if($cred->notes)
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 max-w-xl">{{ $cred->notes }}</p>
                                    @endif
                                </div>
                                <div class="md:w-80">
                                    <div x-data="{visible:false,value:'{{ $cred->password }}',copied:false, masked() { return value.length>4 ? value.slice(0,2)+'•••'+value.slice(-2) : '••••'; }}" class="flex items-center gap-2">
                                        <span x-text="visible ? value : masked()" class="font-mono text-sm text-gray-700 dark:text-gray-200"></span>
                                        <button @click="visible=!visible" type="button" class="text-[10px] px-2 py-1 rounded bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500"> <span x-show="!visible">Mostrar</span><span x-show="visible">Ocultar</span></button>
                                        <button @click="navigator.clipboard.writeText(value); copied=true; setTimeout(()=>copied=false,1500)" type="button" class="text-[10px] px-2 py-1 rounded bg-indigo-600 hover:bg-indigo-500 text-white" x-text="copied ? 'Copiado!' : 'Copiar'"></button>
                                    </div>
                                </div>
                                @if($isAdmin)
                                    <div class="flex gap-2">
                                        <details class="relative">
                                            <summary class="cursor-pointer text-xs px-2 py-1 rounded bg-amber-500/90 hover:bg-amber-500 text-white">Editar</summary>
                                            <div class="absolute z-10 mt-1 right-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md p-4 w-72 shadow-xl">
                                                <form method="POST" action="{{ route('empresa.credentials.update', $cred) }}" class="space-y-2 text-xs" autocomplete="off">
                                                    @csrf
                                                    @method('PUT')
                                                    <input name="category" value="{{ $cred->category }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1" placeholder="Categoria">
                                                    <input name="label" value="{{ $cred->label }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1" required>
                                                    <input name="username" value="{{ $cred->username }}" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1" required>
                                                    <input name="password" placeholder="(manter)" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                                    <textarea name="notes" rows="2" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">{{ $cred->notes }}</textarea>
                                                    <div class="flex justify-end gap-2 pt-1">
                                                        <button class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white rounded">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </details>
                                        <form method="POST" action="{{ route('empresa.credentials.destroy', $cred) }}" onsubmit="return confirm('Remover credencial?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs px-2 py-1 rounded bg-red-600 hover:bg-red-500 text-white">Excluir</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-10 text-center text-gray-500 dark:text-gray-400 italic">Nenhuma credencial cadastrada.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
