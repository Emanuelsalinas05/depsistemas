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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_id')->constrained('sistemas')->cascadeOnDelete()->name('releases_sistema_id_foreign');
            $table->string('version')->index();
            $table->date('fecha_release')->nullable()->index();
            $table->enum('ambiente_objetivo', ['dev', 'qa', 'prod', 'uat', 'otro'])->default('prod')->index();
            $table->longText('changelog')->nullable();
            $table->string('commit_ref')->nullable()->index();
            $table->text('riesgos')->nullable();
            $table->text('rollback_plan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('releases_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};
