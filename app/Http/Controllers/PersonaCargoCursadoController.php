<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaCargoCursado\StorePersonaCargoCursadoRequest;
use App\Http\Requests\PersonaCargoCursado\UpdatePersonaCargoCursadoRequest;
use App\Models\PersonaCargoCursado;
use App\Services\PersonaCargoCursadoService;
use Illuminate\Http\JsonResponse;

class PersonaCargoCursadoController extends Controller
{
    public function __construct(
        protected PersonaCargoCursadoService $personaCargoCursadoService
    ) {}

    public function index(): JsonResponse
    {
        $asignaciones = $this->personaCargoCursadoService->getAll();
        return response()->json($asignaciones);
    }

    public function store(StorePersonaCargoCursadoRequest $request): JsonResponse
    {
        $datos = $request->validated();

        // Validación de duplicado conservada del controlador original
        $existe = PersonaCargoCursado::where('persona_cargos_id', $datos['persona_cargos_id'])
            ->where('cursados_id', $datos['cursados_id'])
            ->exists();

        if ($existe) {
            return response()->json(['mensaje' => 'El registro ya existe.'], 409);
        }

        $asignacion = $this->personaCargoCursadoService->create($datos);
        return response()->json([
            'mensaje'    => 'Registro creado correctamente',
            'asignacion' => $asignacion,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $asignacion = $this->personaCargoCursadoService->findById($id);

        if (!$asignacion) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }

        return response()->json($asignacion);
    }

    public function update(UpdatePersonaCargoCursadoRequest $request, int $id): JsonResponse
    {
        $asignacion = $this->personaCargoCursadoService->update($id, $request->validated());
        return response()->json([
            'mensaje'    => 'Registro actualizado correctamente',
            'asignacion' => $asignacion,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->personaCargoCursadoService->delete($id);
        return response()->json(null, 204);
    }
}
