@php($servicios = $sitio['servicios'])
<section class="sec" id="servicios">
    <x-marca-agua esquina="br" />
    <div class="wrap">
        <div class="sec-head">
            <h2 class="h2">{{ $servicios['titulo'] }}</h2>
            <p class="lead">{{ $servicios['texto'] }}</p>
        </div>
        <div class="svcs">
            @foreach ($servicios['items'] as $svc)
                <article class="svc">
                    <div class="ph"><img src="{{ asset($svc['img']) }}" width="{{ $svc['w'] }}" height="{{ $svc['h'] }}" alt="{{ $svc['alt'] }}" loading="lazy" decoding="async"></div>
                    <h3>{{ $svc['titulo'] }}</h3>
                    <p>{{ $svc['texto'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
