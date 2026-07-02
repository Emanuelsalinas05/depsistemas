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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->name('favoritos_user_id_foreign');
            $table->string('model_type')->index(); // Polimórfico: App\Models\Sistema, App\Models\Proyecto, App\Models\Tarea, App\Models\Documento
            $table->unsignedBigInteger('model_id')->index();
            $table->timestamp('created_at');
            
            // Índice compuesto para búsquedas polimórficas
            $table->index(['model_type', 'model_id']);
            
            // Unique para evitar duplicados
            $table->unique(['user_id', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
