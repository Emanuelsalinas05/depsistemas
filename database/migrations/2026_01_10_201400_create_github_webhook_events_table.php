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
        Schema::create('github_webhook_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')->nullable()->constrained('github_installations')->nullOnDelete()->index()->name('github_webhook_events_installation_id_foreign');
            $table->string('event_name')->index(); // pull_request, push, release, etc.
            $table->string('delivery_id')->index(); // X-GitHub-Delivery header
            $table->string('signature')->nullable(); // X-Hub-Signature-256
            $table->longText('payload'); // JSON bruto del webhook
            $table->dateTime('received_at')->index();
            $table->dateTime('processed_at')->nullable()->index();
            $table->enum('status', ['received', 'processed', 'failed'])->default('received')->index();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            // Índices compuestos para consultas frecuentes
            $table->index(['event_name', 'received_at']);
            $table->index(['status', 'received_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_webhook_events');
    }
};
