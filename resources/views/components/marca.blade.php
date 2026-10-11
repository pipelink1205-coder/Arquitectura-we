@props([
    'ancho' => 48,
    'alto' => 48,
    'carga' => null,
])

<img
    {{ $attributes->merge(['class' => 'marca']) }}
    src="{{ asset($sitio['marca']['monograma']) }}"
    alt="{{ $sitio['marca']['monograma_alt'] }}"
    width="{{ $ancho }}"
    height="{{ $alto }}"
    @if ($carga) loading="{{ $carga }}" @endif
>
