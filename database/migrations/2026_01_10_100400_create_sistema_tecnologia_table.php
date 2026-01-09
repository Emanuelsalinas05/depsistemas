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
        Schema::create('sistema_tecnologia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete()->name('sistema_tecnologia_sistema_id_foreign');
            $table->foreignId('tecnologia_id')->constrained('tecnologias')->cascadeOnDelete()->name('sistema_tecnologia_tecnologia_id_foreign');
            $table->string('version_usada')->nullable();
            $table->timestamps();
            
            $table->unique(['sistema_id', 'tecnologia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistema_tecnologia');
    }
};
