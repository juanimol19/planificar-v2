<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;

// Interfaces
use App\Repositories\Interfaces\PersonaRepositoryInterface;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\SitRevistaRepositoryInterface;
use App\Repositories\Interfaces\AreaRepositoryInterface;
use App\Repositories\Interfaces\CursoRepositoryInterface;
use App\Repositories\Interfaces\CursadoRepositoryInterface;
use App\Repositories\Interfaces\PersonaCargoRepositoryInterface;
use App\Repositories\Interfaces\PersonaCargoCursadoRepositoryInterface;
use App\Repositories\Interfaces\PlanificacionAnualRepositoryInterface;
use App\Repositories\Interfaces\PlanificacionDiariaRepositoryInterface;
use App\Repositories\Interfaces\EstadoAnualRepositoryInterface;
use App\Repositories\Interfaces\EstadoDiariaRepositoryInterface;

// Implementaciones
use App\Repositories\PersonaRepository;
use App\Repositories\CargoRepository;
use App\Repositories\SitRevistaRepository;
use App\Repositories\AreaRepository;
use App\Repositories\CursoRepository;
use App\Repositories\CursadoRepository;
use App\Repositories\PersonaCargoRepository;
use App\Repositories\PersonaCargoCursadoRepository;
use App\Repositories\PlanificacionAnualRepository;
use App\Repositories\PlanificacionDiariaRepository;
use App\Repositories\EstadoAnualRepository;
use App\Repositories\EstadoDiariaRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PersonaRepositoryInterface::class,           PersonaRepository::class);
        $this->app->bind(CargoRepositoryInterface::class,             CargoRepository::class);
        $this->app->bind(SitRevistaRepositoryInterface::class,        SitRevistaRepository::class);
        $this->app->bind(AreaRepositoryInterface::class,              AreaRepository::class);
        $this->app->bind(CursoRepositoryInterface::class,             CursoRepository::class);
        $this->app->bind(CursadoRepositoryInterface::class,           CursadoRepository::class);
        $this->app->bind(PersonaCargoRepositoryInterface::class,      PersonaCargoRepository::class);
        $this->app->bind(PersonaCargoCursadoRepositoryInterface::class, PersonaCargoCursadoRepository::class);
        $this->app->bind(PlanificacionAnualRepositoryInterface::class, PlanificacionAnualRepository::class);
        $this->app->bind(PlanificacionDiariaRepositoryInterface::class, PlanificacionDiariaRepository::class);
        $this->app->bind(EstadoAnualRepositoryInterface::class,       EstadoAnualRepository::class);
        $this->app->bind(EstadoDiariaRepositoryInterface::class,      EstadoDiariaRepository::class);
        $this->app->bind(AuthRepositoryInterface::class,             AuthRepository::class);
    }

    public function boot(): void
    {
        //
    }
}