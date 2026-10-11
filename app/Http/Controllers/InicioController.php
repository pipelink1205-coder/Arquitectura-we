<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class InicioController extends Controller
{
    public function __invoke(): View
    {
        $sitio = config('sitio');

        // Conteo de obras por categoría para los filtros del portafolio
        $conteos = collect($sitio['obras'])->countBy('cat')->all();

        return view('inicio', compact('conteos'));
    }
}
