<?php

namespace App\Jobs;

use App\Models\Recordatorio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatoriosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ahora = now();

        // Obtener recordatorios pendientes que deben enviarse
        $recordatorios = Recordatorio::where('enviado', false)
            ->where('recordar_en', '<=', $ahora)
            ->with('user')
            ->get();

        foreach ($recordatorios as $recordatorio) {
            try {
                // Aquí puedes implementar el envío de notificaciones
                // Por ahora solo marcamos como enviado
                // En producción, usarías: Mail::to($recordatorio->user->email)->send(...)
                // o Notification::send($recordatorio->user, new RecordatorioNotification($recordatorio));

                $recordatorio->update([
                    'enviado' => true,
                ]);

                Log::info("Recordatorio enviado: {$recordatorio->id} para usuario {$recordatorio->user_id}");
            } catch (\Exception $e) {
                Log::error("Error al enviar recordatorio {$recordatorio->id}: " . $e->getMessage());
            }
        }

        Log::info("Procesados {$recordatorios->count()} recordatorios.");
    }
}
