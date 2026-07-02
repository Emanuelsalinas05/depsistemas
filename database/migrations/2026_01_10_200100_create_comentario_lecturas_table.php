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
        Schema::create('comentario_lecturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comentario_id')->constrained('comentarios')->cascadeOnDelete()->name('comentario_lecturas_comentario_id_foreign');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->name('comentario_lecturas_user_id_foreign');
            $table->dateTime('leido_en')->index();
            $table->timestamps();
            
            $table->unique(['comentario_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario_lecturas');
    }
};
