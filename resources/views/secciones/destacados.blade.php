@php($destacados = $sitio['destacados'])
<section class="sec dark" id="destacados">
    <x-marca-agua esquina="bl" />
    <div class="wrap">
        <div class="sec-head">
            <h2 class="h2">{{ $destacados['titulo'] }}</h2>
            <p class="lead">{{ $destacados['texto'] }}</p>
        </div>
        <div class="feats">
            @foreach ($destacados['items'] as $feat)
                <article class="feat">
                    <div class="ph"><img src="{{ asset($feat['img']) }}" width="{{ $feat['w'] }}" height="{{ $feat['h'] }}" alt="{{ $feat['alt'] }}" loading="lazy" decoding="async"></div>
                    <div>
                        <p class="meta"><span>{{ $feat['tipo'] }}</span><span>{{ $feat['lugar'] }}</span></p>
                        <h3>{{ $feat['titulo'] }}</h3>
                        <p>{{ $feat['texto'] }}</p>
                        <span class="idx">{{ $loop->iteration }} de {{ $loop->count }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
