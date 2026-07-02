<?php

namespace App\Console\Commands;

use App\Jobs\EnviarRecordatoriosJob;
use Illuminate\Console\Command;

class EnviarRecordatoriosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorios:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios pendientes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Enviando recordatorios pendientes...');
        
        EnviarRecordatoriosJob::dispatch();

        $this->info('Recordatorios enviados.');
        
        return Command::SUCCESS;
    }
}
