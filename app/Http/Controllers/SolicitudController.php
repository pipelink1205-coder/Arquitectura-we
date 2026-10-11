<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudRequest;
use App\Mail\SolicitudRecibida;
use App\Models\Solicitud;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SolicitudController extends Controller
{
    private const EXITO = 'Mensaje enviado. Te responderemos muy pronto.';

    public function store(SolicitudRequest $request): JsonResponse|RedirectResponse
    {
        // A los bots se les responde igual que a una persona, sin guardar nada.
        if ($request->esSpam()) {
            return $this->responder($request, self::EXITO);
        }

        $solicitud = Solicitud::create([
            ...$request->safe()->except('consentimiento'),
            'ip' => $request->ip(),
        ]);

        try {
            Mail::to(config('sitio.empresa.email'))->send(new SolicitudRecibida($solicitud));
        } catch (Throwable $e) {
            // La solicitud ya quedó guardada: no se pierde aunque falle el correo.
            Log::error('No se pudo enviar el correo de la solicitud #'.$solicitud->id, ['error' => $e->getMessage()]);
        }

        return $this->responder($request, self::EXITO);
    }

    private function responder(SolicitudRequest $request, string $mensaje): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'mensaje' => $mensaje]);
        }

        return redirect()->to(route('inicio').'#contacto')->with('solicitud_ok', $mensaje);
    }
}
