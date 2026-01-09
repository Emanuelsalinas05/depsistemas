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
        Schema::create('minutas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->constrained('reuniones')->cascadeOnDelete()->name('minutas_reunion_id_foreign');
            $table->longText('resumen')->nullable();
            $table->longText('decisiones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('minutas_created_by_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutas');
    }
};
