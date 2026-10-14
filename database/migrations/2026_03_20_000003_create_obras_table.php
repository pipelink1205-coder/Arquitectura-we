<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('cat', 32);
            $table->string('titulo');
            $table->text('texto');
            $table->string('img');
            $table->unsignedSmallInteger('w')->default(900);
            $table->unsignedSmallInteger('h')->default(900);
            $table->string('alt');
            $table->string('etiqueta')->nullable();
            $table->unsignedSmallInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
