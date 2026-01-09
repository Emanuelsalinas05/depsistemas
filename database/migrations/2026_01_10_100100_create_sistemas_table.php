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
        Schema::create('sistemas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index();
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('area_usuaria')->nullable()->index();
            $table->string('dueno_funcional')->nullable();
            $table->enum('criticidad', ['alta', 'media', 'baja'])->default('media')->index();
            $table->enum('estatus', ['activo', 'mantenimiento', 'legado', 'deprecado'])->default('activo')->index();
            $table->string('url_prod')->nullable();
            $table->string('url_qa')->nullable();
            $table->string('url_dev')->nullable();
            $table->string('repositorio_url')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('sistemas_created_by_foreign');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('sistemas_updated_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistemas');
    }
};
