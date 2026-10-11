<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Solicitud de propuesta recibida desde la web.
 *
 * @property int $id
 * @property string $nombre
 * @property string $telefono
 * @property string|null $correo
 * @property string $servicio
 * @property string $mensaje
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $atendida_en
 */
class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'servicio',
        'mensaje',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'atendida_en' => 'datetime',
        ];
    }

    /** Solicitudes que aún no se han atendido. */
    public function scopePendientes(Builder $query): Builder
    {
        return $query->whereNull('atendida_en');
    }

    /** Enlace de WhatsApp para responderle directamente al cliente. */
    public function whatsappUrl(): string
    {
        $numero = preg_replace('/\D/', '', $this->telefono);

        if (strlen($numero) === 10) {
            $numero = '57'.$numero; // Celular colombiano sin indicativo
        }

        return 'https://wa.me/'.$numero;
    }
}
