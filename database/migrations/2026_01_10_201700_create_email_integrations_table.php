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
        Schema::create('email_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index(); // Nombre de la integración (ej: "SMTP Principal", "Gmail API")
            $table->enum('tipo', ['smtp', 'gmail_api', 'outlook_api', 'otro'])->default('smtp')->index();
            $table->string('servidor')->nullable(); // Para SMTP
            $table->integer('puerto')->nullable(); // Para SMTP
            $table->string('usuario')->nullable()->index();
            $table->string('secret_ref')->nullable(); // referencia a bóveda externa para contraseñas/tokens
            $table->boolean('tls')->default(true)->index();
            $table->boolean('ssl')->default(false)->index();
            $table->json('configuracion')->nullable(); // Configuración adicional (encryption, auth, etc.)
            $table->boolean('notificaciones_activas')->default(true)->index(); // Enviar notificaciones automáticas
            $table->boolean('recordatorios_activos')->default(true)->index(); // Enviar recordatorios
            $table->boolean('reportes_activos')->default(true)->index(); // Enviar reportes programados
            $table->json('plantillas')->nullable(); // Plantillas de correo personalizadas
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('email_integrations_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_integrations');
    }
};
