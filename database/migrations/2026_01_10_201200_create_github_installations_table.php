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
        Schema::create('github_installations', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->default('github')->index();
            $table->string('installation_id')->unique(); // ID de GitHub App Installation
            $table->string('account_login')->index();
            $table->string('account_type')->nullable(); // User/Org
            $table->json('metadata')->nullable();
            $table->string('secret_ref')->nullable(); // referencia a bóveda externa para tokens
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('github_installations_created_by_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_installations');
    }
};
