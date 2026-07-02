<?php

namespace App\Providers;

use App\Models\Acuerdo;
use App\Models\Comentario;
use App\Models\ContactoInteraccion;
use App\Models\Documento;
use App\Models\DocumentoVersion;
use App\Models\GithubInstallation;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\ReporteEjecucion;
use App\Models\ReporteJasper;
use App\Models\Sistema;
use App\Models\Tarea;
use App\Models\Worklog;
use App\Observers\ModelObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.force_https')) {
            URL::forceScheme('https');
        }

        // Registrar observers para setear created_by/updated_by automáticamente
        Sistema::observe(ModelObserver::class);
        Tarea::observe(ModelObserver::class);
        Documento::observe(ModelObserver::class);
        DocumentoVersion::observe(ModelObserver::class);
        Comentario::observe(ModelObserver::class);
        Worklog::observe(ModelObserver::class);
        Acuerdo::observe(ModelObserver::class);
        ContactoInteraccion::observe(ModelObserver::class);
        ReporteJasper::observe(ModelObserver::class);
        ReporteEjecucion::observe(ModelObserver::class);
        GithubInstallation::observe(ModelObserver::class);
    }
}
