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
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->nullable()->constrained('reuniones')->nullOnDelete()->name('acuerdos_reunion_id_foreign');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->name('acuerdos_proyecto_id_foreign');
            $table->string('titulo')->index();
            $table->text('detalle')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete()->name('acuerdos_responsable_id_foreign')->index();
            $table->date('fecha_compromiso')->nullable()->index();
            $table->enum('estatus', ['pendiente', 'en_progreso', 'cumplido', 'cancelado'])->default('pendiente')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acuerdos');
    }
};
