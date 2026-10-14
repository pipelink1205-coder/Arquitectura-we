<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['titulo', 'texto', 'img', 'w', 'h', 'alt', 'orden', 'activo'])]
class Servicio extends Model
{
    /** @param  Builder<static>  $query */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /** @param  Builder<static>  $query */
    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('orden')->orderBy('id');
    }

    /** @return array<string, mixed> */
    public function toSitioItem(): array
    {
        return [
            'titulo' => $this->titulo,
            'texto' => $this->texto,
            'img' => $this->img,
            'w' => $this->w,
            'h' => $this->h,
            'alt' => $this->alt,
        ];
    }
}
