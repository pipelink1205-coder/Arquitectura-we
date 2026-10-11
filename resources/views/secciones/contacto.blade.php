@php($empresa = $sitio['empresa'])
@php($contacto = $sitio['contacto'])
<section class="sec contacto" id="contacto">
    <x-marca-agua esquina="bl" />
    <div class="wrap contacto-grid">
        <div>
            <h2 class="h2">{{ $contacto['titulo'] }}</h2>
            <p class="lead" style="margin-top:20px">{{ $contacto['texto'] }}</p>

            <div class="equipo">
                @foreach ($sitio['equipo'] as $persona)
                    <div class="persona">
                        <div><b>{{ $persona['nombre'] }}</b><span>{{ $persona['telefono_visible'] }}</span></div>
                        <div class="acc">
                            <a class="chip" href="tel:+{{ $persona['telefono'] }}"><x-icono nombre="telefono" />Llamar</a>
                            <a class="chip wa" href="https://wa.me/{{ $persona['telefono'] }}?text={{ rawurlencode('Hola '.$persona['saludo'].', quisiera información sobre un proyecto.') }}" target="_blank" rel="noopener"><x-icono nombre="whatsapp" />WhatsApp</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="dir">
                <a href="mailto:{{ $empresa['email'] }}">{{ $empresa['email'] }}</a>
                <span>{{ $empresa['direccion'] }}, {{ $empresa['ciudad'] }}</span>
                <a href="{{ $empresa['mapa'] }}" target="_blank" rel="noopener">Abrir en Google Maps</a>
            </div>
        </div>

        {{--
            Funciona con y sin JavaScript:
            - Con JS: se valida en el navegador y se envía por fetch (respuesta JSON).
            - Sin JS: envío normal, Laravel valida y regresa con errores u old().
        --}}
        <form class="form" id="form" method="POST" action="{{ route('solicitudes.store') }}" data-correo="{{ $empresa['email'] }}" novalidate>
            @csrf
            <h3>{{ $contacto['form_titulo'] }}</h3>

            <div class="fila">
                <label>Nombre
                    <input id="fn" name="nombre" type="text" autocomplete="name" maxlength="120" required value="{{ old('nombre') }}" @error('nombre') aria-invalid="true" @enderror>
                    @error('nombre')<span class="campo-err">{{ $message }}</span>@enderror
                </label>
                <label>Teléfono
                    <input id="ft" name="telefono" type="tel" inputmode="tel" autocomplete="tel" maxlength="40" required value="{{ old('telefono') }}" @error('telefono') aria-invalid="true" @enderror>
                    @error('telefono')<span class="campo-err">{{ $message }}</span>@enderror
                </label>
            </div>

            <label>Correo electrónico (opcional)
                <input id="fe" name="correo" type="email" autocomplete="email" maxlength="160" value="{{ old('correo') }}" @error('correo') aria-invalid="true" @enderror>
                @error('correo')<span class="campo-err">{{ $message }}</span>@enderror
            </label>

            <div class="fila">
                <label>Servicio de interés
                    <select id="fs" name="servicio">
                        @foreach ($contacto['servicios'] as $servicio)
                            <option @selected(old('servicio') === $servicio)>{{ $servicio }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Hablar por WhatsApp con
                    <select id="fw">
                        @foreach ($sitio['equipo'] as $persona)
                            <option value="{{ $persona['telefono'] }}|{{ $persona['saludo'] }}">{{ $persona['nombre'] }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label>Cuéntanos tu proyecto
                <textarea id="fm" name="mensaje" maxlength="3000" required placeholder="Tipo de obra, municipio y lo que necesitas" @error('mensaje') aria-invalid="true" @enderror>{{ old('mensaje') }}</textarea>
                @error('mensaje')<span class="campo-err">{{ $message }}</span>@enderror
            </label>

            {{-- Campo trampa para bots: las personas no lo ven --}}
            <input id="fh" class="hp" name="_honey" tabindex="-1" autocomplete="off" aria-hidden="true">

            <label class="consent">
                <input type="checkbox" id="fc" name="consentimiento" value="1" @checked(old('consentimiento')) @error('consentimiento') aria-invalid="true" @enderror>
                <span>Autorizo el tratamiento de mis datos personales para responder esta solicitud (Ley 1581 de 2012).</span>
            </label>
            @error('consentimiento')<span class="campo-err">{{ $message }}</span>@enderror

            <div class="acciones">
                <button type="button" class="btn btn-wa" id="wa"><x-icono nombre="whatsapp" />Enviar por WhatsApp</button>
                <button type="submit" class="btn btn-cobalto" id="send">Enviar por correo</button>
            </div>

            <p @class(['status', 'ok' => session('solicitud_ok'), 'err' => $errors->any()]) id="st" role="status" aria-live="polite">
                @if (session('solicitud_ok'))
                    {{ session('solicitud_ok') }}
                @elseif ($errors->any())
                    Revisa los campos marcados.
                @endif
            </p>
        </form>
    </div>
</section>
