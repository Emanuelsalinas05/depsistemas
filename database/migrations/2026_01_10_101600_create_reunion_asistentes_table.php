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
        Schema::create('reunion_asistentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->constrained('reuniones')->cascadeOnDelete()->name('reunion_asistentes_reunion_id_foreign');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->name('reunion_asistentes_user_id_foreign');
            $table->string('nombre_externo')->nullable();
            $table->string('email_externo')->nullable();
            $table->timestamps();
            
            $table->unique(['reunion_id', 'user_id', 'email_externo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunion_asistentes');
    }
};
