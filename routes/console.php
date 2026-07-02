<?php

use App\Jobs\EnviarRecordatoriosJob;
use App\Jobs\ProcesarWebhookJob;
use App\Models\GithubWebhookEvent;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduler: Enviar recordatorios cada 5 minutos
Schedule::call(function () {
    EnviarRecordatoriosJob::dispatch();
})->everyFiveMinutes()
  ->name('enviar-recordatorios')
  ->withoutOverlapping();

// Scheduler: Procesar webhooks pendientes cada minuto
Schedule::call(function () {
    $webhooks = GithubWebhookEvent::where('status', 'received')
        ->where('received_at', '>=', now()->subHours(24))
        ->limit(10)
        ->get();
    
    foreach ($webhooks as $webhook) {
        ProcesarWebhookJob::dispatch($webhook);
    }
})->everyMinute()
  ->name('procesar-webhooks')
  ->withoutOverlapping();
