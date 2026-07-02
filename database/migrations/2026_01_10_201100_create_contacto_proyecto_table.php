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
        Schema::create('contacto_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contacto_id')->constrained('contactos')->cascadeOnDelete()->name('contacto_proyecto_contacto_id_foreign');
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete()->name('contacto_proyecto_proyecto_id_foreign');
            $table->string('tipo')->nullable(); // usuario clave, sponsor, proveedor, etc.
            $table->timestamps();
            
            $table->unique(['contacto_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacto_proyecto');
    }
};
