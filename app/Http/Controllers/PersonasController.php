<?php

namespace App\Http\Controllers;

use App\Http\Requests\Persona\StorePersonaRequest;
use App\Http\Requests\Persona\UpdatePersonaRequest;
use App\Services\PersonaService;
use Illuminate\Http\JsonResponse;

class PersonasController extends Controller
{
    public function __construct(
        protected PersonaService $personaService
    ) {}

    public function index(): JsonResponse
    {
        $personas = $this->personaService->getAll();
        return response()->json($personas);
    }

    public function store(StorePersonaRequest $request): JsonResponse
    {
        $persona = $this->personaService->create($request->validated());
        return response()->json([
            'mensaje' => 'Persona agregada correctamente',
            'persona' => $persona,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $persona = $this->personaService->findById($id);

        if (!$persona) {
            return response()->json(['mensaje' => 'Persona no encontrada'], 404);
        }

        return response()->json($persona);
    }

    public function update(UpdatePersonaRequest $request, int $id): JsonResponse
    {
        $persona = $this->personaService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Persona actualizada correctamente',
            'persona' => $persona,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->personaService->delete($id);
        return response()->json(['mensaje' => 'Persona eliminada correctamente']);
    }
}
