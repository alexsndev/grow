<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
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
        <!-- Título -->
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100">
            Demandas para: 
            <span class="text-blue-600 dark:text-blue-400">
                {{ ucfirst(str_replace('-', ' ', $slug)) }}
            </span>
        </h1>

    <x-company-tabs :slug="$slug" active="demands" :credentials-count="$credentialsCount" :demands-count="$demands->count()" />

    <!-- Formulário de criação -->
        @auth
            @if(auth()->user()->email !== 'admin@admin.com')
                <div class="mb-10 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">Criar nova demanda</h2>
                    <form action="{{ url('/empresa/'.$slug) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="text" name="title" placeholder="Título" 
                                   class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 
                                          bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                          focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        </div>
                        <div>
                            <textarea name="description" rows="4" placeholder="Descrição"
                                      class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 
                                             bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                             focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos (imagens ou vídeos)</label>
                            <input type="file" name="attachments[]" multiple accept="image/*,video/*" class="block w-full text-sm text-gray-700 dark:text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formatos permitidos: png, jpg, jpeg, webp, gif, mp4, mov, avi, mkv. Máx ~25MB cada (não validado no servidor ainda).</p>
                        </div>
                        <div>
                            <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                Criar demanda
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-10 p-4 bg-yellow-100 dark:bg-yellow-800 border border-yellow-300 dark:border-yellow-600 rounded-lg text-sm">
                    <span class="font-semibold">Modo administrador:</span> você vê todas as demandas enviadas pelos clientes para esta empresa.
                </div>
            @endif
        @endauth

        <!-- Lista de demandas -->
        <div class="space-y-6">
            @forelse($demands as $d)
                <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between gap-6">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">{{ $d->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $d->description }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                Enviada por: <span class="font-medium">{{ optional($d->user)->email ?? 'Anônimo' }}</span> • {{ $d->created_at->diffForHumans() }}
                            </p>
                            @if($d->attachments->count())
                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3" x-data="{ open:false, focusIndex:0, items: [] }" x-init="items = [...$el.querySelectorAll('[data-att-index]')].map(el => ({url:el.dataset.url,type:el.dataset.type,name:el.dataset.name}))">
                                    @foreach($d->attachments as $i => $att)
                                        @php $isVideo = str_starts_with($att->mime_type,'video'); @endphp
                                        <div 
                                            class="group relative border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden bg-gray-50 dark:bg-gray-900 cursor-pointer"
                                            data-att-index="{{$i}}" data-url="{{ $att->url }}" data-type="{{ $isVideo ? 'video':'image' }}" data-name="{{ $att->original_name }}"
                                            @click="open=true; focusIndex={{$i}}"
                                        >
                                            @if($isVideo)
                                                <video class="w-full h-28 object-cover pointer-events-none" preload="metadata">
                                                    <source src="{{ $att->url }}#t=0.1" type="{{ $att->mime_type }}" />
                                                </video>
                                                <span class="absolute top-1 left-1 bg-black/60 text-[10px] px-1 rounded text-white">Vídeo</span>
                                            @else
                                                <img src="{{ $att->url }}" alt="{{ $att->original_name }}" class="w-full h-28 object-cover" loading="lazy" />
                                            @endif
                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-[10px] text-gray-200 p-1 text-center leading-tight">
                                                {{ \Illuminate\Support\Str::limit($att->original_name, 28) }}<br>
                                                <span class="text-[9px] opacity-70">Clique para ampliar</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Lightbox Modal -->
                                    <template x-if="open">
                                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" x-transition @keydown.escape.window="open=false" @click.self="open=false">
                                            <div class="relative max-w-5xl w-full" x-data="{ get current(){return items[focusIndex]||null;} }">
                                                <div class="absolute -top-10 right-0 flex gap-2">
                                                    <button @click="open=false" class="px-3 py-1 text-xs rounded bg-gray-700/70 text-gray-200 hover:bg-gray-600">Fechar</button>
                                                </div>
                                                <div class="bg-gray-900 rounded-lg p-4 shadow-xl border border-gray-700/60">
                                                    <div class="flex justify-between items-start mb-3 gap-4">
                                                        <h4 class="text-sm font-medium text-gray-200 truncate" x-text="current?.name"></h4>
                                                        <div class="flex gap-2">
                                                            <template x-if="current && current.type==='image'">
                                                                <a :href="current.url" download class="px-2 py-1 text-xs rounded bg-indigo-600 hover:bg-indigo-500 text-white">Baixar</a>
                                                            </template>
                                                            <template x-if="current && current.type==='video'">
                                                                <a :href="current.url" download class="px-2 py-1 text-xs rounded bg-indigo-600 hover:bg-indigo-500 text-white">Baixar vídeo</a>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div class="relative max-h-[70vh] flex items-center justify-center overflow-hidden">
                                                        <template x-if="current && current.type==='image'">
                                                            <img :src="current.url" :alt="current.name" class="max-h-[70vh] rounded object-contain" />
                                                        </template>
                                                        <template x-if="current && current.type==='video'">
                                                            <video :src="current.url" class="max-h-[70vh] rounded" controls autoplay></video>
                                                        </template>
                                                    </div>
                                                    <div class="mt-4 flex justify-between text-xs text-gray-400">
                                                        <button class="px-2 py-1 rounded bg-gray-800 hover:bg-gray-700 disabled:opacity-40" :disabled="focusIndex===0" @click.stop="if(focusIndex>0) focusIndex--">Anterior</button>
                                                        <span><span x-text="focusIndex+1"></span>/<span x-text="items.length"></span></span>
                                                        <button class="px-2 py-1 rounded bg-gray-800 hover:bg-gray-700 disabled:opacity-40" :disabled="focusIndex===items.length-1" @click.stop="if(focusIndex<items.length-1) focusIndex++">Próximo</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            @endif
                        </div>
                        <div class="w-44 text-right">
                            <div class="mb-3 text-sm flex flex-col items-end">
                                <span class="text-[10px] uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</span>
                                @php
                                    $map = [
                                        'pending' => ['label' => 'Pendente', 'cls' => 'bg-red-500/15 text-red-500 dark:text-red-400 border border-red-500/30'],
                                        'in_progress' => ['label' => 'Em andamento', 'cls' => 'bg-yellow-500/15 text-yellow-600 dark:text-yellow-400 border border-yellow-500/30'],
                                        'completed' => ['label' => 'Concluído', 'cls' => 'bg-green-500/15 text-green-600 dark:text-green-400 border border-green-500/30'],
                                    ];
                                    $badge = $map[$d->status] ?? ['label'=>$d->status,'cls'=>'bg-gray-500/20 text-gray-300 border border-gray-600'];
                                @endphp
                                <span class="mt-1 text-[11px] font-medium px-2 py-1 rounded {{$badge['cls']}}">{{$badge['label']}}</span>
                            </div>

                            @if(auth()->check() && auth()->user()->email === 'admin@admin.com')
                                <form action="{{ route('demands.update', $d) }}" method="POST" class="mb-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" 
                                            class="border rounded p-2 w-full text-sm 
                                                   dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200
                                                   focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="pending" {{ $d->status=='pending'?'selected':'' }}>Pendente</option>
                                        <option value="in_progress" {{ $d->status=='in_progress'?'selected':'' }}>Em andamento</option>
                                        <option value="completed" {{ $d->status=='completed'?'selected':'' }}>Concluído</option>
                                    </select>
                                    <button class="mt-2 w-full px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition flex items-center justify-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 5a1 1 0 011 1v2.586l1.293-1.293a1 1 0 111.414 1.414l-3.004 3.004a1 1 0 01-1.414 0L6.285 8.707a1 1 0 011.414-1.414L9 8.586V6a1 1 0 011-1z"/><path d="M3 10a7 7 0 1111.95 4.95 1 1 0 11-1.414-1.415A5 5 0 1010 15v1.382a1 1 0 11-2 0V15a7.002 7.002 0 01-5-6z"/></svg>
                                        Atualizar
                                    </button>
                                </form>
                                <form action="{{ route('demands.destroy', $d) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta demanda?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                                        Remover
                                    </button>
                                </form>
                            @elseif(auth()->check() && auth()->id() === $d->user_id)
                                <details class="text-left mb-3 group">
                                    <summary class="cursor-pointer text-xs text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400">Editar minha demanda</summary>
                                    <form action="{{ route('demands.update', $d) }}" method="POST" class="mt-2 space-y-2" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="title" value="{{ $d->title }}" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm px-2 py-1 focus:ring-2 focus:ring-indigo-500" required>
                                        <textarea name="description" rows="3" class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm px-2 py-1 focus:ring-2 focus:ring-indigo-500">{{ $d->description }}</textarea>
                                        @php $remaining = max(0, 10 - $d->attachments->count()); @endphp
                                        @if($remaining > 0)
                                            <div class="pt-1">
                                                <label class="block text-[11px] tracking-wide uppercase text-gray-500 dark:text-gray-400 mb-1">Adicionar anexos (até {{ $remaining }})</label>
                                                <input type="file" name="attachments[]" multiple accept="image/*,video/*" class="block w-full text-xs text-gray-700 dark:text-gray-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer" />
                                            </div>
                                        @else
                                            <p class="text-[11px] text-gray-500 dark:text-gray-400">Limite de 10 anexos atingido.</p>
                                        @endif
                                        <button class="w-full px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-medium transition">Salvar alterações</button>
                                    </form>
                                    @if($d->attachments->count())
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach($d->attachments as $att)
                                                @php $isVideo = str_starts_with($att->mime_type,'video'); @endphp
                                                <div class="relative border border-gray-200 dark:border-gray-700 rounded overflow-hidden group">
                                                    @if($isVideo)
                                                        <video class="w-full h-20 object-cover" preload="metadata">
                                                            <source src="{{ $att->url }}#t=0.1" type="{{ $att->mime_type }}" />
                                                        </video>
                                                    @else
                                                        <img src="{{ $att->url }}" class="w-full h-20 object-cover" />
                                                    @endif
                                                    <form action="{{ route('attachments.destroy', $att) }}" method="POST" class="absolute top-1 right-1" onsubmit="return confirm('Remover anexo?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-600/80 hover:bg-red-600 text-white rounded text-[10px] px-1.5 py-0.5">X</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </details>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 dark:text-gray-400 italic py-10">
                    Nenhuma demanda foi criada ainda.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
