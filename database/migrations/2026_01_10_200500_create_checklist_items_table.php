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
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained('checklists')->cascadeOnDelete()->name('checklist_items_checklist_id_foreign');
            $table->string('texto');
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('done')->default(false)->index();
            $table->foreignId('done_by')->nullable()->constrained('users')->nullOnDelete()->name('checklist_items_done_by_foreign');
            $table->dateTime('done_at')->nullable()->index();
            $table->timestamps();
            
            // Índice compuesto para ordenamiento
            $table->index(['checklist_id', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};
