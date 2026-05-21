<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cursado\StoreCursadoRequest;
use App\Http\Requests\Cursado\UpdateCursadoRequest;
use App\Services\CursadoService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class CursadosController extends Controller
{
    public function __construct(
        protected CursadoService $cursadoService
    ) {}

    public function index(): JsonResponse
    {
        $cursados = $this->cursadoService->getAll();
        return response()->json($cursados);
    }

    public function store(StoreCursadoRequest $request): JsonResponse
    {
        $cursado = $this->cursadoService->create($request->validated());
        return response()->json([
            'mensaje'  => 'Cursado creado correctamente',
            'cursado'  => $cursado,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $cursado = $this->cursadoService->findById($id);

        if (!$cursado) {
            return response()->json(['mensaje' => 'Cursado no encontrado'], 404);
        }

        return response()->json($cursado);
    }

    public function update(UpdateCursadoRequest $request, int $id): JsonResponse
    {
        $cursado = $this->cursadoService->update($id, $request->validated());
        return response()->json([
            'mensaje'  => 'Cursado actualizado correctamente',
            'cursado'  => $cursado,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->cursadoService->delete($id);
            return response()->json(null, 204);
        } catch (QueryException $e) {
            // Código 23000: violación de integridad referencial
            if ($e->getCode() === '23000') {
                return response()->json([
                    'mensaje' => 'No se puede eliminar el cursado. Existen relaciones activas en persona_cargo_cursado.',
                ], 409);
            }
            return response()->json([
                'mensaje' => 'Error inesperado al eliminar el cursado.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
