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
        Schema::create('google_drive_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->name('google_drive_integrations_user_id_foreign');
            $table->string('drive_folder_id')->nullable()->index(); // ID de la carpeta en Google Drive
            $table->string('drive_folder_name')->nullable(); // Nombre de la carpeta
            $table->string('email')->nullable()->index(); // Email de la cuenta de Google
            $table->string('secret_ref')->nullable(); // referencia a bóveda externa para tokens OAuth
            $table->enum('tipo', ['usuario', 'sistema', 'proyecto'])->default('usuario')->index();
            $table->foreignId('sistema_id')->nullable()->constrained('sistemas')->nullOnDelete()->name('google_drive_integrations_sistema_id_foreign');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->name('google_drive_integrations_proyecto_id_foreign');
            $table->boolean('sync_documentos')->default(true)->index(); // Sincronizar documentos del sistema
            $table->boolean('sync_bidireccional')->default(false)->index(); // Sincronización bidireccional
            $table->json('metadata')->nullable(); // Configuración adicional
            $table->timestamp('last_sync_at')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('google_drive_integrations_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para búsquedas
            $table->index('sistema_id');
            $table->index('proyecto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_drive_integrations');
    }
};
