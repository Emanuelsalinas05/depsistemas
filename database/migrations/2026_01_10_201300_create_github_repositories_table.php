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
        Schema::create('github_repositories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->nullable()->constrained('github_installations')->nullOnDelete()->name('github_repositories_installation_id_foreign');
            $table->string('repo_id')->unique(); // ID numérico del repositorio en GitHub
            $table->string('full_name')->index(); // org/repo
            $table->string('default_branch')->nullable();
            $table->foreignId('sistema_id')->nullable()->constrained('sistemas')->nullOnDelete()->name('github_repositories_sistema_id_foreign');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->name('github_repositories_proyecto_id_foreign');
            $table->boolean('is_active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas por sistema y proyecto
            $table->index('sistema_id');
            $table->index('proyecto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_repositories');
    }
};
