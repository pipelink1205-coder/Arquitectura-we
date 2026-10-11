<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Solicitudes de propuesta enviadas desde el formulario de contacto.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('telefono', 40);
            $table->string('correo', 160)->nullable();
            $table->string('servicio', 60);
            $table->text('mensaje');
            $table->string('ip', 45)->nullable();
            $table->timestamp('atendida_en')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
