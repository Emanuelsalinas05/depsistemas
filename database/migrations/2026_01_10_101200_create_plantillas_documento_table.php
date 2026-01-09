<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plantillas_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index();
            $table->enum('tipo', ['manual_tecnico', 'manual_usuario', 'runbook', 'adr', 'postmortem'])->index();
            $table->enum('formato', ['markdown', 'html'])->default('markdown');
            $table->longText('contenido_template');
            $table->string('version')->nullable()->index();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantillas_documento');
    }
};
