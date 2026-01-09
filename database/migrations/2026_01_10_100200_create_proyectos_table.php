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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->nullable()->constrained('sistemas')->nullOnDelete()->name('proyectos_sistema_id_foreign');
            $table->string('nombre')->index();
            $table->string('slug')->unique();
            $table->text('objetivo')->nullable();
            $table->date('fecha_inicio')->nullable()->index();
            $table->date('fecha_fin')->nullable()->index();
            $table->enum('estatus', ['planeado', 'en_progreso', 'en_pausa', 'cerrado'])->default('planeado')->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('proyectos_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('proyectos_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
