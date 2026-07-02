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
        Schema::create('ia_generaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->nullable()->constrained('ia_prompts')->nullOnDelete()->name('ia_generaciones_prompt_id_foreign');
            $table->string('model_type')->nullable()->index(); // Referencia polimórfica opcional
            $table->unsignedBigInteger('model_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->index()->name('ia_generaciones_user_id_foreign');
            $table->longText('input_context')->nullable(); // JSON/texto de contexto enviado
            $table->longText('output_text')->nullable(); // Texto generado por la IA
            $table->json('meta')->nullable(); // tokens, costo, modelo usado, etc.
            $table->enum('status', ['success', 'failed'])->default('success')->index();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            // Índices compuestos para consultas frecuentes
            $table->index(['user_id', 'created_at']);
            $table->index(['status', 'created_at']);
            
            // Índice compuesto para búsquedas polimórficas
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia_generaciones');
    }
};
