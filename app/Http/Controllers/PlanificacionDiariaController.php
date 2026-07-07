<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanificacionDiaria\StorePlanificacionDiariaRequest;
use App\Http\Requests\PlanificacionDiaria\UpdatePlanificacionDiariaRequest;
use App\Services\PlanificacionDiariaService;
use Illuminate\Http\JsonResponse;

class PlanificacionDiariaController extends Controller
{
    public function __construct(
        protected PlanificacionDiariaService $planificacionDiariaService
    ) {}

    public function index(): JsonResponse
{
    $user = auth()->user();
    $personaCargoCursadoId = null;

    if ($user->hasRole('docente', 'api')) {
        $personaCargo = $user->persona?->personaCargos?->first();
        $personaCargoCursadoId = $personaCargo?->personaCargoCursados?->first()?->id;
    }

    $planificaciones = $this->planificacionDiariaService->getAll($personaCargoCursadoId);
    return response()->json($planificaciones);
}

    public function store(StorePlanificacionDiariaRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionDiariaService->create($request->validated());
        return response()->json([
            'mensaje'       => 'Planificación diaria agregada correctamente',
            'planificacion' => $planificacion,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $planificacion = $this->planificacionDiariaService->findById($id);

        if (!$planificacion) {
            return response()->json(['mensaje' => 'Planificación diaria no encontrada'], 404);
        }

        return response()->json($planificacion);
    }

    public function update(UpdatePlanificacionDiariaRequest $request, int $id): JsonResponse
    {
        $planificacion = $this->planificacionDiariaService->update($id, $request->validated());
        return response()->json([
            'mensaje'       => 'Planificación diaria actualizada correctamente',
            'planificacion' => $planificacion,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planificacionDiariaService->delete($id);
        return response()->json(['mensaje' => 'Planificación diaria eliminada correctamente']);
    }
}
