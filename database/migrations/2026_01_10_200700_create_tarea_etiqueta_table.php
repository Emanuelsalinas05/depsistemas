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
        Schema::create('tarea_etiqueta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete()->name('tarea_etiqueta_tarea_id_foreign');
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete()->name('tarea_etiqueta_etiqueta_id_foreign');
            $table->timestamps();
            
            $table->unique(['tarea_id', 'etiqueta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_etiqueta');
    }
};
