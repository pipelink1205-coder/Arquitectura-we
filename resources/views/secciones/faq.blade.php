@php
    $faq = $sitio['faq'];
@endphp
<section class="sec faq" aria-labelledby="t-faq">
    <x-marca-agua esquina="tl" />
    <div class="wrap faq-grid">
        <div>
            <h2 class="h2" id="t-faq">{{ $faq['titulo'] }}</h2>
            <p class="lead" style="margin-top:20px">{{ $faq['texto'] }}</p>
        </div>
        <div>
            @foreach ($faq['items'] as $item)
                <details><summary>{{ $item['p'] }}<i aria-hidden="true"></i></summary><p>{{ $item['r'] }}</p></details>
            @endforeach
        </div>
    </div>
</section>

@push('head')
    {{-- Datos estructurados de preguntas frecuentes para Google --}}
    @php
        $preguntas = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faq['items'])->map(fn ($i) => [
                '@type' => 'Question',
                'name' => $i['p'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['r']],
            ])->all(),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($preguntas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush
