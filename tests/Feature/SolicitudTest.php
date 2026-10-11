<?php

namespace Tests\Feature;

use App\Mail\SolicitudRecibida;
use App\Models\Solicitud;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SolicitudTest extends TestCase
{
    use RefreshDatabase;

    private function datos(array $cambios = []): array
    {
        return array_merge([
            'nombre' => 'Laura Gómez',
            'telefono' => '300 123 4567',
            'correo' => 'laura@example.com',
            'servicio' => 'Construcción',
            'mensaje' => 'Quiero construir una casa de campo en Sopetrán.',
            'consentimiento' => '1',
        ], $cambios);
    }

    public function test_guarda_la_solicitud_y_envia_el_correo(): void
    {
        Mail::fake();

        $this->postJson(route('solicitudes.store'), $this->datos())
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertDatabaseHas('solicitudes', ['nombre' => 'Laura Gómez', 'servicio' => 'Construcción']);

        Mail::assertSent(SolicitudRecibida::class, function (SolicitudRecibida $mail) {
            return $mail->hasTo(config('sitio.empresa.email'))
                && $mail->hasReplyTo('laura@example.com');
        });
    }

    public function test_sin_javascript_redirige_al_formulario_con_mensaje(): void
    {
        Mail::fake();

        $this->post(route('solicitudes.store'), $this->datos())
            ->assertRedirect(route('inicio').'#contacto')
            ->assertSessionHas('solicitud_ok');
    }

    public function test_valida_los_campos_obligatorios(): void
    {
        $this->postJson(route('solicitudes.store'), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nombre', 'telefono', 'servicio', 'mensaje', 'consentimiento']);

        $this->assertDatabaseCount('solicitudes', 0);
    }

    public function test_rechaza_telefono_corto_correo_invalido_y_servicio_inexistente(): void
    {
        $this->postJson(route('solicitudes.store'), $this->datos([
            'telefono' => '12-34',
            'correo' => 'no-es-correo',
            'servicio' => 'Demolición',
        ]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['telefono', 'correo', 'servicio']);
    }

    public function test_el_correo_es_opcional(): void
    {
        Mail::fake();

        $this->postJson(route('solicitudes.store'), $this->datos(['correo' => '']))->assertOk();

        $this->assertNull(Solicitud::first()->correo);
    }

    public function test_ignora_a_los_bots_que_llenan_el_campo_trampa(): void
    {
        Mail::fake();

        $this->postJson(route('solicitudes.store'), $this->datos(['_honey' => 'spam']))
            ->assertOk();

        $this->assertDatabaseCount('solicitudes', 0);
        Mail::assertNothingSent();
    }

    public function test_limita_los_envios_repetidos(): void
    {
        Mail::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->postJson(route('solicitudes.store'), $this->datos())->assertOk();
        }

        $this->postJson(route('solicitudes.store'), $this->datos())->assertTooManyRequests();
    }

    public function test_si_falla_el_correo_la_solicitud_igual_queda_guardada(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP caído'));

        $this->postJson(route('solicitudes.store'), $this->datos())->assertOk();

        $this->assertDatabaseCount('solicitudes', 1);
    }

    public function test_genera_el_enlace_de_whatsapp_con_indicativo_de_colombia(): void
    {
        $solicitud = new Solicitud(['telefono' => '300 123 4567']);

        $this->assertSame('https://wa.me/573001234567', $solicitud->whatsappUrl());
    }
}
