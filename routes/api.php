<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\SitRevistaController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\CursadosController;
use App\Http\Controllers\PersonaCargosController;
use App\Http\Controllers\PersonaCargoCursadoController;
use App\Http\Controllers\PlanificacionAnualController;
use App\Http\Controllers\PlanificacionDiariaController;
use App\Http\Controllers\EstadosAnualController;
use App\Http\Controllers\EstadosDiariaController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ── Rutas públicas ─────────────────────────────────────────────────────
Route::post('login', [AuthController::class, 'login']);

// ── Rutas autenticadas ─────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // ── Solo Director ──────────────────────────────────────────────
    Route::middleware('role:director|vicedirector|secretario')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::apiResource('personas',              PersonasController::class);
        Route::apiResource('cargos',                CargosController::class);
        Route::apiResource('sit-revista',           SitRevistaController::class);
        Route::apiResource('areas',                 AreasController::class);
        Route::apiResource('cursos',                CursosController::class);
        Route::apiResource('cursados',              CursadosController::class);
        Route::apiResource('persona-cargos',        PersonaCargosController::class);
        Route::apiResource('persona-cargo-cursado', PersonaCargoCursadoController::class);

        Route::get('persona-cargos-detalle', [PersonaCargosController::class, 'cargosPersona']);
    });

    // ── Director y Docente ─────────────────────────────────────────
    Route::middleware('role:director|docente')->group(function () {
        Route::apiResource('planificacion-anual',  PlanificacionAnualController::class);
        Route::apiResource('planificacion-diaria', PlanificacionDiariaController::class);
        Route::apiResource('estados-anual',        EstadosAnualController::class);
        Route::apiResource('estados-diaria',       EstadosDiariaController::class);
    });

});