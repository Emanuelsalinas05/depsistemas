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
        Schema::create('proyecto_miembros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete()->name('proyecto_miembros_proyecto_id_foreign');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->name('proyecto_miembros_user_id_foreign');
            $table->enum('rol_en_proyecto', ['pm', 'dev', 'qa', 'soporte', 'consulta'])->default('dev')->index();
            $table->boolean('asignacion_activa')->default(true);
            $table->timestamps();
            
            $table->unique(['proyecto_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_miembros');
    }
};
