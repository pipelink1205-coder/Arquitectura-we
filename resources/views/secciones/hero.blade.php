@php($hero = $sitio['hero'])
<section class="hero" id="inicio">
    <x-marca-agua centro />
    <div class="wrap">
        <div class="hero-in">
            <div class="hero-txt">
                <h1>{{ $hero['titulo'] }}</h1>
                <p>{{ $hero['texto'] }}</p>
                <div class="hero-btns">
                    <a class="btn btn-senal" href="#contacto">Solicitar propuesta</a>
                    <a class="btn btn-linea" href="#proyectos">Ver proyectos</a>
                </div>
            </div>
            <figure class="photo">
                <span class="cota cota-h" aria-hidden="true"><b>{{ $hero['cota_h'] }}</b></span>
                <span class="cota cota-v" aria-hidden="true"><b>{{ $hero['cota_v'] }}</b></span>
                <div class="frame">
                    <img src="{{ asset($hero['imagen']['src']) }}" width="{{ $hero['imagen']['w'] }}" height="{{ $hero['imagen']['h'] }}" alt="{{ $hero['imagen']['alt'] }}" fetchpriority="high">
                </div>
                <figcaption><strong>{{ $hero['pie_titulo'] }}</strong><span>{{ $hero['pie_texto'] }}</span></figcaption>
            </figure>
        </div>
        <div class="facts">
            @foreach ($sitio['cifras'] as $cifra)
                <div class="fact">
                    <b>{{ $cifra['prefijo'] }}<span data-n="{{ $cifra['n'] }}">{{ $cifra['n'] }}</span>@if ($cifra['unidad'])<small>{{ $cifra['unidad'] }}</small>@endif</b>
                    <span>{{ $cifra['texto'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
