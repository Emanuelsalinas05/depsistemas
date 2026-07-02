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
        Schema::create('documento_etiqueta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete()->name('documento_etiqueta_documento_id_foreign');
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete()->name('documento_etiqueta_etiqueta_id_foreign');
            $table->timestamps();
            
            $table->unique(['documento_id', 'etiqueta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_etiqueta');
    }
};
