{{-- Botón flotante de WhatsApp --}}
<a class="fab" href="{{ 'https://wa.me/'.$sitio['empresa']['whatsapp'].'?text='.rawurlencode('Hola, quisiera información sobre un proyecto.') }}" target="_blank" rel="noopener" aria-label="Escribir por WhatsApp">
    <x-icono nombre="whatsapp-fab" />
</a>

{{-- Volver arriba --}}
<button class="arriba" id="arriba" type="button" aria-label="Volver arriba">
    <x-icono nombre="arriba" />
</button>

{{-- Visor de fotos del portafolio --}}
<dialog class="lb" id="lb" aria-label="Foto ampliada">
    <div class="lb-img"><img id="lb-img" src="data:," alt=""></div>
    <div class="lb-bar">
        <p id="lb-cap"></p>
        <div class="lb-nav">
            <button type="button" id="lb-prev" aria-label="Foto anterior"><x-icono nombre="anterior" /></button>
            <button type="button" id="lb-next" aria-label="Foto siguiente"><x-icono nombre="siguiente" /></button>
        </div>
    </div>
    <button type="button" class="lb-x" id="lb-x" aria-label="Cerrar"><x-icono nombre="cerrar" /></button>
</dialog>
