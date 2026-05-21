<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaCargo\StorePersonaCargoRequest;
use App\Http\Requests\PersonaCargo\UpdatePersonaCargoRequest;
use App\Services\PersonaCargoService;
use Illuminate\Http\JsonResponse;

class PersonaCargosController extends Controller
{
    public function __construct(
        protected PersonaCargoService $personaCargoService
    ) {}

    public function index(): JsonResponse
    {
        $registros = $this->personaCargoService->getAll();
        return response()->json($registros);
    }

    /**
     * Listado con join completo: persona + cargo + sit_revista
     * Conservado del controlador original.
     */
    public function cargosPersona(): JsonResponse
    {
        // El repositorio ya eager-loadea persona, cargo y sitRevista
        $registros = $this->personaCargoService->getAll();
        return response()->json($registros);
    }

    public function store(StorePersonaCargoRequest $request): JsonResponse
    {
        $personaCargo = $this->personaCargoService->create($request->validated());
        return response()->json([
            'mensaje'       => 'Registro creado correctamente',
            'persona_cargo' => $personaCargo,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $registro = $this->personaCargoService->findById($id);

        if (!$registro) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    public function update(UpdatePersonaCargoRequest $request, int $id): JsonResponse
    {
        $personaCargo = $this->personaCargoService->update($id, $request->validated());
        return response()->json([
            'mensaje'       => 'Registro actualizado correctamente',
            'persona_cargo' => $personaCargo,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->personaCargoService->delete($id);
        return response()->json(['mensaje' => 'Registro eliminado correctamente']);
    }
}
