<?php

namespace App\Providers;

use App\Models\Acuerdo;
use App\Models\Checklist;
use App\Models\Comentario;
use App\Models\Contacto;
use App\Models\Documento;
use App\Models\GithubInstallation;
use App\Models\GithubRepository;
use App\Models\IaGeneracion;
use App\Models\IaPrompt;
use App\Models\PlantillaDocumento;
use App\Models\Proyecto;
use App\Models\Release;
use App\Models\Reunion;
use App\Models\ReporteJasper;
use App\Models\Sistema;
use App\Models\Tarea;
use App\Models\Worklog;
use App\Policies\AcuerdoPolicy;
use App\Policies\ChecklistPolicy;
use App\Policies\ComentarioPolicy;
use App\Policies\ContactoPolicy;
use App\Policies\DocumentoPolicy;
use App\Policies\GithubPolicy;
use App\Policies\IaPolicy;
use App\Policies\ProyectoPolicy;
use App\Policies\ReleasePolicy;
use App\Policies\ReunionPolicy;
use App\Policies\ReporteJasperPolicy;
use App\Policies\SistemaPolicy;
use App\Policies\TareaPolicy;
use App\Policies\WorklogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Sistema::class => SistemaPolicy::class,
        Proyecto::class => ProyectoPolicy::class,
        Tarea::class => TareaPolicy::class,
        Documento::class => DocumentoPolicy::class,
        PlantillaDocumento::class => DocumentoPolicy::class, // Reutiliza DocumentoPolicy
        Worklog::class => WorklogPolicy::class,
        Release::class => ReleasePolicy::class,
        Reunion::class => ReunionPolicy::class,
        Acuerdo::class => AcuerdoPolicy::class,
        Contacto::class => ContactoPolicy::class,
        ReporteJasper::class => ReporteJasperPolicy::class,
        GithubInstallation::class => GithubPolicy::class,
        GithubRepository::class => GithubPolicy::class,
        IaPrompt::class => IaPolicy::class,
        IaGeneracion::class => IaPolicy::class,
        Checklist::class => ChecklistPolicy::class,
        Comentario::class => ComentarioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Superadmin puede hacer todo
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
