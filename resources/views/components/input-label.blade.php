@props(['value'])

<label {{ $attributes->class(['block font-medium text-sm'])->merge(['class']) }}>
    {{ $value ?? $slot }}
</label>
