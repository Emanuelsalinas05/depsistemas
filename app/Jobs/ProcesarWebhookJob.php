<?php

namespace App\Jobs;

use App\Models\GithubWebhookEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcesarWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $webhookEvent;

    /**
     * Create a new job instance.
     */
    public function __construct(GithubWebhookEvent $webhookEvent)
    {
        $this->webhookEvent = $webhookEvent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            /** @var GithubWebhookEvent|null $event */
            $event = GithubWebhookEvent::query()
                ->whereKey($this->webhookEvent->id)
                ->lockForUpdate()
                ->first();

            if (! $event || $event->status !== 'received') {
                return;
            }

            try {
                $payload = json_decode($event->payload, true);

                switch ($event->event_name) {
                    case 'push':
                        $this->procesarPush($payload, $event);
                        break;
                    case 'pull_request':
                        $this->procesarPullRequest($payload, $event);
                        break;
                    case 'release':
                        $this->procesarRelease($payload, $event);
                        break;
                    default:
                        Log::info("Evento no procesado: {$event->event_name}", ['github_webhook_event_id' => $event->id]);
                }

                $event->update([
                    'status' => 'processed',
                    'processed_at' => now(),
                ]);

                Log::info('Webhook procesado', ['github_webhook_event_id' => $event->id]);
            } catch (\Throwable $e) {
                $event->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                Log::error('Error al procesar webhook', [
                    'github_webhook_event_id' => $event->id,
                    'exception' => $e->getMessage(),
                ]);

                throw $e;
            }
        });
    }

    private function procesarPush(?array $payload, GithubWebhookEvent $event): void
    {
        Log::info('Procesando push event', ['github_webhook_event_id' => $event->id]);
    }

    private function procesarPullRequest(?array $payload, GithubWebhookEvent $event): void
    {
        Log::info('Procesando pull request event', ['github_webhook_event_id' => $event->id]);
    }

    private function procesarRelease(?array $payload, GithubWebhookEvent $event): void
    {
        Log::info('Procesando release event', ['github_webhook_event_id' => $event->id]);
    }
}
