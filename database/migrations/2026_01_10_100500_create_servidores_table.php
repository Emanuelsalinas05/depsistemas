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
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index();
            $table->enum('tipo', ['fisico', 'vm', 'cloud', 'contenedor'])->index();
            $table->string('proveedor')->nullable()->index();
            $table->string('hostname')->nullable();
            $table->string('ip')->nullable()->index();
            $table->string('so')->nullable();
            $table->integer('cpu')->nullable();
            $table->integer('ram_gb')->nullable();
            $table->integer('disco_gb')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('secret_ref')->nullable();
            $table->enum('estatus', ['activo', 'baja', 'mantenimiento'])->default('activo')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servidores');
    }
};
