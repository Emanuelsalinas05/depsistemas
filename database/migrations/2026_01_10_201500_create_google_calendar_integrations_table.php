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
        Schema::create('google_calendar_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->name('google_calendar_integrations_user_id_foreign');
            $table->string('calendar_id')->nullable()->index(); // ID del calendario de Google
            $table->string('calendar_name')->nullable(); // Nombre del calendario
            $table->string('email')->index(); // Email de la cuenta de Google
            $table->string('secret_ref')->nullable(); // referencia a bóveda externa para tokens OAuth
            $table->boolean('sync_reuniones')->default(true)->index(); // Sincronizar reuniones del sistema
            $table->boolean('sync_bidireccional')->default(false)->index(); // Sincronización bidireccional
            $table->json('metadata')->nullable(); // Configuración adicional
            $table->timestamp('last_sync_at')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('google_calendar_integrations_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
            
            // Un usuario puede tener múltiples calendarios, pero un email único por integración activa
            // Nota: El constraint único con is_active no es estándar en MySQL, se maneja a nivel de aplicación
            $table->index(['user_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_calendar_integrations');
    }
};
