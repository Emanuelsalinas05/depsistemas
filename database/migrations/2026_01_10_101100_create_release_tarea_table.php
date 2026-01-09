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
        Schema::create('release_tarea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('release_id')->constrained('releases')->cascadeOnDelete()->name('release_tarea_release_id_foreign');
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete()->name('release_tarea_tarea_id_foreign');
            $table->timestamps();
            
            $table->unique(['release_id', 'tarea_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_tarea');
    }
};
