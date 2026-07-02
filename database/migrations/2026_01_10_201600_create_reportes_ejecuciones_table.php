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
        Schema::create('reportes_ejecuciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes_jasper')->cascadeOnDelete()->name('reportes_ejecuciones_reporte_id_foreign');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->index()->name('reportes_ejecuciones_user_id_foreign');
            $table->json('parametros')->nullable(); // Parámetros pasados al reporte
            $table->enum('output', ['pdf', 'xlsx', 'csv', 'html'])->index();
            $table->enum('status', ['queued', 'running', 'success', 'failed'])->default('queued')->index();
            $table->dateTime('started_at')->nullable()->index();
            $table->dateTime('finished_at')->nullable()->index();
            $table->string('archivo_path')->nullable(); // Ruta del archivo generado
            $table->longText('error_log')->nullable();
            $table->unsignedInteger('runtime_ms')->nullable(); // Tiempo de ejecución en milisegundos
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('reportes_ejecuciones_created_by_foreign');
            $table->timestamps();
            
            // Índices compuestos para consultas frecuentes
            $table->index(['reporte_id', 'created_at']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_ejecuciones');
    }
};
