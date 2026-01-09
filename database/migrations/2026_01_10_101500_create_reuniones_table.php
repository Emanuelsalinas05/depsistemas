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
        Schema::create('reuniones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->name('reuniones_proyecto_id_foreign');
            $table->string('titulo')->index();
            $table->dateTime('fecha_inicio')->index();
            $table->dateTime('fecha_fin')->nullable();
            $table->string('ubicacion')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('reuniones_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reuniones');
    }
};
