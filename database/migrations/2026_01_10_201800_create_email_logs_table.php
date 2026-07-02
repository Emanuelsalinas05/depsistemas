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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_integration_id')->nullable()->constrained('email_integrations')->nullOnDelete()->name('email_logs_email_integration_id_foreign');
            $table->string('tipo')->index(); // notificacion, recordatorio, reporte, manual
            $table->string('referencia_tipo')->nullable()->index(); // tarea, acuerdo, reunion, documento, etc.
            $table->unsignedBigInteger('referencia_id')->nullable()->index();
            $table->string('destinatario')->index();
            $table->string('asunto');
            $table->text('contenido')->nullable();
            $table->enum('estado', ['pendiente', 'enviado', 'fallido', 'cancelado'])->default('pendiente')->index();
            $table->timestamp('enviado_at')->nullable()->index();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Headers, attachments info, etc.
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('email_logs_created_by_foreign');
            $table->timestamps();
            
            // Índices compuestos para búsquedas
            $table->index(['referencia_tipo', 'referencia_id']);
            $table->index(['estado', 'enviado_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
