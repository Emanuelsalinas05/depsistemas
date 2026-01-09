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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambiente_id')->constrained('ambientes')->cascadeOnDelete()->name('servicios_ambiente_id_foreign');
            $table->enum('tipo', ['db', 'cache', 'queue', 'storage', 'api', 'otro'])->index();
            $table->string('nombre')->index();
            $table->string('version')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('secret_ref')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
