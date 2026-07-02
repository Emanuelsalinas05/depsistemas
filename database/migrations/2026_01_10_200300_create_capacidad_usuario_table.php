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
        Schema::create('capacidad_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->name('capacidad_usuario_user_id_foreign');
            $table->decimal('horas_por_dia', 4, 2)->default(6.00);
            $table->json('dias_semana')->nullable(); // ej: ["mon","tue","wed","thu","fri"]
            $table->date('vigente_desde')->index();
            $table->date('vigente_hasta')->nullable()->index();
            $table->timestamps();
            
            $table->unique(['user_id', 'vigente_desde']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacidad_usuario');
    }
};
