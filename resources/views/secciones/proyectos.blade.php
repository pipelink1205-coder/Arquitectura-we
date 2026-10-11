@php($obras = $sitio['obras'])
<section class="sec" id="proyectos">
    <x-marca-agua esquina="tr" />
    <div class="wrap">
        <div class="sec-head">
            <h2 class="h2">{{ $sitio['proyectos']['titulo'] }}</h2>
            <p class="lead">{{ $sitio['proyectos']['texto'] }}</p>
        </div>
        <div class="filtros" role="group" aria-label="Filtrar proyectos">
            <button type="button" aria-pressed="true" data-f="all">Todos<sup>{{ count($obras) }}</sup></button>
            @foreach ($sitio['categorias'] as $clave => $etiqueta)
                @if (! empty($conteos[$clave]))
                    <button type="button" aria-pressed="false" data-f="{{ $clave }}">{{ $etiqueta }}<sup>{{ $conteos[$clave] }}</sup></button>
                @endif
            @endforeach
        </div>
        <div class="obras" id="obras">
            @foreach ($obras as $obra)
                <article class="obra" data-c="{{ $obra['cat'] }}">
                    <button type="button" aria-label="Ampliar foto: {{ $obra['titulo'] }}">
                        <img src="{{ asset($obra['img']) }}" width="{{ $obra['w'] }}" height="{{ $obra['h'] }}" alt="{{ $obra['alt'] }}" loading="lazy" decoding="async">
                    </button>
                    <span class="cat">{{ $obra['etiqueta'] ?? $sitio['categorias'][$obra['cat']] }}</span>
                    <h3>{{ $obra['titulo'] }}</h3>
                    <p>{{ $obra['texto'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
