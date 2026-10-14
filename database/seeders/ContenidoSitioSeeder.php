<?php

namespace Database\Seeders;

use App\Models\Obra;
use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ContenidoSitioSeeder extends Seeder
{
    public function run(): void
    {
        if (Servicio::query()->exists() || Obra::query()->exists()) {
            return;
        }

        $sitio = config('sitio');

        foreach ($sitio['servicios']['items'] as $i => $item) {
            Servicio::query()->create([
                'titulo' => $item['titulo'],
                'texto' => $item['texto'],
                'img' => $item['img'],
                'w' => $item['w'],
                'h' => $item['h'],
                'alt' => $item['alt'],
                'orden' => $i + 1,
                'activo' => true,
            ]);
        }

        foreach ($sitio['obras'] as $i => $item) {
            Obra::query()->create([
                'cat' => $item['cat'],
                'titulo' => $item['titulo'],
                'texto' => $item['texto'],
                'img' => $item['img'],
                'w' => $item['w'],
                'h' => $item['h'],
                'alt' => $item['alt'],
                'etiqueta' => $item['etiqueta'] ?? null,
                'orden' => $i + 1,
                'activo' => true,
            ]);
        }
    }
}
