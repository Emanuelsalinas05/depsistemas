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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete()->name('documentos_sistema_id_foreign');
            $table->foreignId('release_id')->nullable()->constrained('releases')->nullOnDelete()->name('documentos_release_id_foreign');
            $table->enum('tipo', ['manual_tecnico', 'manual_usuario', 'runbook', 'adr', 'postmortem'])->index();
            $table->string('titulo')->index();
            $table->enum('estado', ['borrador', 'publicado', 'archivado'])->default('borrador')->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('documentos_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('documentos_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
