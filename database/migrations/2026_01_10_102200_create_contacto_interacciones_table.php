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
        Schema::create('contacto_interacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contacto_id')->constrained('contactos')->cascadeOnDelete()->name('contacto_interacciones_contacto_id_foreign');
            $table->enum('tipo', ['llamada', 'correo', 'reunion', 'ticket', 'nota'])->default('nota')->index();
            $table->text('detalle');
            $table->dateTime('fecha')->index();
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->name('contacto_interacciones_proyecto_id_foreign');
            $table->foreignId('sistema_id')->nullable()->constrained('sistemas')->nullOnDelete()->name('contacto_interacciones_sistema_id_foreign');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('contacto_interacciones_created_by_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacto_interacciones');
    }
};
