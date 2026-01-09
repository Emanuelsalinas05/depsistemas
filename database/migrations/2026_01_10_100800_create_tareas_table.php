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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete()->name('tareas_proyecto_id_foreign');
            $table->string('titulo')->index();
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['feature', 'bug', 'soporte', 'mejora', 'doc'])->default('feature')->index();
            $table->enum('prioridad', ['alta', 'media', 'baja'])->default('media')->index();
            $table->enum('estado', ['nuevo', 'en_curso', 'en_revision', 'listo_release', 'cerrado'])->default('nuevo')->index();
            $table->foreignId('asignado_a')->nullable()->constrained('users')->nullOnDelete()->index()->name('tareas_asignado_a_foreign');
            $table->date('fecha_inicio')->nullable()->index();
            $table->date('fecha_fin')->nullable()->index();
            $table->decimal('estimacion_horas', 6, 2)->nullable();
            $table->tinyInteger('progreso')->default(0);
            $table->string('evidencia_url')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('tareas_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('tareas_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Índice FULLTEXT para búsqueda en descripción
        Schema::table('tareas', function (Blueprint $table) {
            $table->fullText('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
