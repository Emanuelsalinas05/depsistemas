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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->index(); // Polimórfico: App\Models\Tarea, App\Models\Release, App\Models\Documento
            $table->unsignedBigInteger('model_id')->index();
            $table->string('titulo');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('checklists_created_by_foreign');
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
        Schema::dropIfExists('checklists');
    }
};
