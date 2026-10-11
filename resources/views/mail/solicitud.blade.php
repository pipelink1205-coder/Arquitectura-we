<x-mail::message>
# Nueva solicitud de propuesta

Llegó una consulta desde el formulario de la página web.

<x-mail::table>
| Campo | Detalle |
|:--------- |:--------- |
| **Nombre** | {{ $solicitud->nombre }} |
| **Teléfono** | {{ $solicitud->telefono }} |
| **Correo** | {{ $solicitud->correo ?: 'No indicado' }} |
| **Servicio** | {{ $solicitud->servicio }} |
| **Fecha** | {{ $solicitud->created_at->timezone('America/Bogota')->format('d/m/Y h:i a') }} |
</x-mail::table>

**Mensaje**

<x-mail::panel>
{{ $solicitud->mensaje }}
</x-mail::panel>

<x-mail::button :url="$solicitud->whatsappUrl()" color="success">
Responder por WhatsApp
</x-mail::button>

@if ($solicitud->correo)
También puedes responder este correo directamente: la respuesta le llegará a {{ $solicitud->nombre }}.
@endif

Solicitud #{{ $solicitud->id }}<br>
{{ config('app.name') }}
</x-mail::message>
