<?php

namespace App\Services;

use App\Models\Obra;
use App\Models\Servicio;
use Illuminate\Support\Facades\Schema;

class SitioBuilder
{
    /** @return array<string, mixed> */
    public function build(): array
    {
        $sitio = config('sitio');

        if (! Schema::hasTable('servicios') || ! Schema::hasTable('obras')) {
            return $sitio;
        }

        if (Servicio::query()->activos()->exists()) {
            $sitio['servicios']['items'] = Servicio::query()
                ->activos()
                ->ordenados()
                ->get()
                ->map(fn (Servicio $s) => $s->toSitioItem())
                ->all();
        }

        if (Obra::query()->activos()->exists()) {
            $sitio['obras'] = Obra::query()
                ->activos()
                ->ordenados()
                ->get()
                ->map(fn (Obra $o) => $o->toSitioItem())
                ->all();
        }

        return $sitio;
    }
}
