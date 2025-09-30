@props([
    'slug',
    'active' => 'demands', // demands | credentials
    'demandsCount' => null,
    'credentialsCount' => null,
])
@php
    $tabs = [
        'demands' => [
            'label' => 'Demandas',
            'href' => url('/empresa/'.$slug),
            'count' => $demandsCount,
        ],
        'credentials' => [
            'label' => 'Credenciais',
            'href' => url('/empresa/'.$slug.'/credenciais'),
            'count' => $credentialsCount,
        ],
    ];
@endphp
<div class="mt-2 mb-8 border-b border-gray-200 dark:border-gray-700 flex flex-wrap gap-4 sticky top-16 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur px-2 rounded-b">
    @foreach($tabs as $key => $t)
        @php $isActive = $active === $key; @endphp
        <a href="{{ $t['href'] }}" class="relative pb-3 pt-2 px-1 text-sm font-medium tracking-wide {{ $isActive ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
            <span class="flex items-center gap-2">
                {{ $t['label'] }}
                @if(!is_null($t['count']))
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-semibold">{{ $t['count'] }}</span>
                @endif
            </span>
            @if($isActive)
                <span class="absolute left-0 -bottom-px h-[3px] w-full rounded-t bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></span>
            @endif
        </a>
    @endforeach
</div>