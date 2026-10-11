@props([
    /** Centro de la sección (solo hero / primera pantalla) */
    'centro' => false,
    /** Esquina: br, bl, tr, tl */
    'esquina' => 'br',
])

<img
    {{ $attributes->class([
        'marca-agua',
        'marca-agua--centro' => $centro,
        'marca-agua--br' => ! $centro && $esquina === 'br',
        'marca-agua--bl' => ! $centro && $esquina === 'bl',
        'marca-agua--tr' => ! $centro && $esquina === 'tr',
        'marca-agua--tl' => ! $centro && $esquina === 'tl',
    ]) }}
    src="{{ asset($sitio['marca']['monograma']) }}"
    alt=""
    aria-hidden="true"
    decoding="async"
    loading="lazy"
>
