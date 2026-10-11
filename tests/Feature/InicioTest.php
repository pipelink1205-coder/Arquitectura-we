<?php

namespace Tests\Feature;

use Tests\TestCase;

class InicioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_la_pagina_principal_carga_con_todas_las_secciones(): void
    {
        $respuesta = $this->get('/');

        $respuesta->assertOk()
            ->assertSee('Ingeniería y arquitectura que transforman espacios.')
            ->assertSee('id="servicios"', false)
            ->assertSee('id="proceso"', false)
            ->assertSee('id="destacados"', false)
            ->assertSee('id="proyectos"', false)
            ->assertSee('id="contacto"', false);
    }

    public function test_muestra_todas_las_obras_y_los_conteos_de_los_filtros(): void
    {
        $obras = config('sitio.obras');

        $respuesta = $this->get('/');

        foreach ($obras as $obra) {
            $respuesta->assertSee($obra['titulo']);
        }

        $respuesta->assertSee('Todos<sup>'.count($obras).'</sup>', false)
            ->assertSee('Tubería PEAD<sup>2</sup>', false);
    }

    public function test_incluye_el_formulario_con_proteccion_csrf_y_los_contactos(): void
    {
        $respuesta = $this->get('/');

        $respuesta->assertSee('action="'.route('solicitudes.store').'"', false)
            ->assertSee('name="_token"', false);

        foreach (config('sitio.equipo') as $persona) {
            $respuesta->assertSee($persona['nombre'])
                ->assertSee('https://wa.me/'.$persona['telefono'], false);
        }
    }

    public function test_incluye_datos_estructurados_para_buscadores(): void
    {
        $this->get('/')
            ->assertSee('"@type":"GeneralContractor"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('<meta property="og:image"', false);
    }
}
