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
        Schema::create('tarea_dependencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete()->name('tarea_dependencias_tarea_id_foreign');
            $table->foreignId('depende_de_tarea_id')->constrained('tareas')->cascadeOnDelete()->name('tarea_dependencias_depende_de_tarea_id_foreign');
            $table->timestamps();
            
            $table->unique(['tarea_id', 'depende_de_tarea_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_dependencias');
    }
};
