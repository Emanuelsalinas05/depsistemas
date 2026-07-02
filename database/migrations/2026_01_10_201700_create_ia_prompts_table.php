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
        Schema::create('ia_prompts', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index();
            $table->enum('tipo', ['manual_tecnico', 'manual_usuario', 'mermaid', 'minuta', 'acuerdos_a_tareas'])->index();
            $table->longText('prompt_template'); // Plantilla del prompt con placeholders
            $table->string('version')->nullable()->index();
            $table->boolean('activo')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('ia_prompts_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia_prompts');
    }
};
