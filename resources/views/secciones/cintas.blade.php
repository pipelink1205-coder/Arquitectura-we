{{-- Cintas de obra animadas: el JS las replica hasta llenar el ancho de pantalla --}}
<div class="cintas" aria-hidden="true">
    @foreach (['b', 'a'] as $tipo)
        <div class="cinta cinta-{{ $tipo }}"><div class="pista">
            @for ($i = 0; $i < 2; $i++)
                <div class="grupo">@foreach ($sitio['cintas'][$tipo] as $texto)<span>{{ $texto }}</span>@endforeach</div>
            @endfor
        </div></div>
    @endforeach
</div>
