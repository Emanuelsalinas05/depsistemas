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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->index(); // Polimórfico: App\Models\Tarea, App\Models\Documento, etc.
            $table->unsignedBigInteger('model_id')->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->index()->name('comentarios_user_id_foreign');
            $table->longText('contenido');
            $table->boolean('is_private')->default(false)->index(); // Para notas internas
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('comentarios_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('comentarios_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
            
            // Índice compuesto para búsquedas polimórficas
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
