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
        Schema::create('ambientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete()->name('ambientes_sistema_id_foreign');
            $table->enum('nombre', ['dev', 'qa', 'prod', 'uat', 'otro'])->index();
            $table->string('url')->nullable();
            $table->foreignId('servidor_id')->nullable()->constrained('servidores')->nullOnDelete()->name('ambientes_servidor_id_foreign');
            $table->text('notas')->nullable();
            $table->timestamps();
            
            $table->unique(['sistema_id', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambientes');
    }
};
