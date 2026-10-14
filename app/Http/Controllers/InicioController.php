<?php

namespace App\Http\Controllers;

use App\Services\SitioBuilder;
use Illuminate\Contracts\View\View;

class InicioController extends Controller
{
    public function __invoke(SitioBuilder $sitioBuilder): View
    {
        $sitio = $sitioBuilder->build();
        $conteos = collect($sitio['obras'])->countBy('cat')->all();

        return view('inicio', compact('conteos'));
    }
}
