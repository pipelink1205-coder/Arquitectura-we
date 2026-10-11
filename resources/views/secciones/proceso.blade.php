@php($proceso = $sitio['proceso'])
<section class="sec proceso" id="proceso">
    <x-marca-agua esquina="tl" />
    <div class="wrap">
        <div class="sec-head">
            <h2 class="h2">{{ $proceso['titulo'] }}</h2>
            <p class="lead">{{ $proceso['texto'] }}</p>
        </div>
        <ol class="pasos">
            @foreach ($proceso['pasos'] as $paso)
                <li><h3>{{ $paso['titulo'] }}</h3><p>{{ $paso['texto'] }}</p></li>
            @endforeach
        </ol>
    </div>
</section>
