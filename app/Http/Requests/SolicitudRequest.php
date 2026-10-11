<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim((string) $this->input('nombre')),
            'telefono' => trim((string) $this->input('telefono')),
            'correo' => trim((string) $this->input('correo')) ?: null,
            'mensaje' => trim((string) $this->input('mensaje')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:120'],
            'telefono' => [
                'required', 'string', 'max:40',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (strlen(preg_replace('/\D/', '', (string) $value)) < 7) {
                        $fail('Escribe un teléfono de contacto válido.');
                    }
                },
            ],
            'correo' => ['nullable', 'email', 'max:160'],
            'servicio' => ['required', Rule::in(config('sitio.contacto.servicios'))],
            'mensaje' => ['required', 'string', 'max:3000'],
            'consentimiento' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Escribe tu nombre.',
            'telefono.required' => 'Escribe un teléfono de contacto válido.',
            'correo.email' => 'Revisa el correo electrónico o déjalo vacío.',
            'servicio.*' => 'Elige un servicio de la lista.',
            'mensaje.required' => 'Cuéntanos brevemente sobre tu proyecto.',
            'mensaje.max' => 'El mensaje es muy largo. Resúmelo en menos de 3000 caracteres.',
            'consentimiento.accepted' => 'Para enviar, acepta el tratamiento de datos.',
            '*.max' => 'Este campo es demasiado largo.',
        ];
    }

    /** ¿Cayó un bot en el campo trampa? */
    public function esSpam(): bool
    {
        return filled($this->input('_honey'));
    }
}
