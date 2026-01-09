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
        Schema::create('documento_versiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete()->name('documento_versiones_documento_id_foreign');
            $table->string('version')->index();
            $table->longText('contenido')->nullable();
            $table->string('archivo_path')->nullable();
            $table->longText('mermaid_source')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('documento_versiones_created_by_foreign');
            $table->timestamp('created_at');
        });
        
        // Índice FULLTEXT para búsqueda en contenido
        Schema::table('documento_versiones', function (Blueprint $table) {
            $table->fullText('contenido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_versiones');
    }
};
