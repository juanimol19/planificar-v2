<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanificacionAnual\StorePlanificacionAnualRequest;
use App\Http\Requests\PlanificacionAnual\UpdatePlanificacionAnualRequest;
use App\Services\PlanificacionAnualService;
use Illuminate\Http\JsonResponse;

class PlanificacionAnualController extends Controller
{
    public function __construct(
        protected PlanificacionAnualService $planificacionAnualService
    ) {}

    public function index(): JsonResponse
    {
        $planificaciones = $this->planificacionAnualService->getAll();
        return response()->json($planificaciones);
    }

    public function store(StorePlanificacionAnualRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionAnualService->create($request->validated());
        return response()->json([
            'mensaje'       => 'Planificación anual creada correctamente',
            'planificacion' => $planificacion,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $planificacion = $this->planificacionAnualService->findById($id);

        if (!$planificacion) {
            return response()->json(['mensaje' => 'Planificación no encontrada'], 404);
        }

        return response()->json($planificacion);
    }

    public function update(UpdatePlanificacionAnualRequest $request, int $id): JsonResponse
    {
        $planificacion = $this->planificacionAnualService->update($id, $request->validated());
        return response()->json([
            'mensaje'       => 'Planificación anual actualizada correctamente',
            'planificacion' => $planificacion,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planificacionAnualService->delete($id);
        return response()->json(['mensaje' => 'Planificación anual eliminada correctamente']);
    }
}
