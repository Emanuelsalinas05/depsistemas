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
        Schema::create('reportes_jasper', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index();
            $table->string('codigo')->unique(); // Clave interna única
            $table->text('descripcion')->nullable();
            $table->string('jrxml_path'); // Ruta al archivo .jrxml
            $table->string('jasper_path')->nullable(); // Ruta al archivo .jasper compilado
            $table->enum('output_default', ['pdf', 'xlsx', 'csv', 'html'])->default('pdf')->index();
            $table->string('datasource')->nullable(); // mysql:default, etc.
            $table->json('parametros_schema')->nullable(); // Definición de parámetros esperados
            $table->string('version')->nullable()->index();
            $table->boolean('activo')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('reportes_jasper_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_jasper');
    }
};
