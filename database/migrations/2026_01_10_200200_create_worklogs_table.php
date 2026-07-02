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
        Schema::create('worklogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete()->name('worklogs_tarea_id_foreign');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->index()->name('worklogs_user_id_foreign');
            $table->date('fecha')->index();
            $table->unsignedInteger('minutos'); // 0..1440 (máximo 24 horas)
            $table->string('descripcion')->nullable();
            $table->enum('source', ['manual', 'timer', 'import'])->default('manual')->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('worklogs_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('worklogs_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices compuestos para consultas de tiempos por tarea y usuario
            $table->index(['tarea_id', 'fecha']);
            $table->index(['user_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worklogs');
    }
};
