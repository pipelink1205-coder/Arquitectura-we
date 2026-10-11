@php($valores = $sitio['valores'])
<section class="sec valores" aria-labelledby="t-valores">
    <x-marca-agua esquina="br" />
    <div class="wrap">
        <div class="sec-head">
            <h2 class="h2" id="t-valores">{{ $valores['titulo'] }}</h2>
            <p class="lead">{{ $valores['texto'] }}</p>
        </div>
        <ul>
            @foreach ($valores['items'] as $valor)
                <li><strong>{{ $valor['titulo'] }}</strong><span>{{ $valor['texto'] }}</span></li>
            @endforeach
        </ul>
    </div>
</section>
