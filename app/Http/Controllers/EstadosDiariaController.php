<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoDiaria\StoreEstadoDiariaRequest;
use App\Http\Requests\EstadoDiaria\UpdateEstadoDiariaRequest;
use App\Services\EstadoDiariaService;
use Illuminate\Http\JsonResponse;

class EstadosDiariaController extends Controller
{
    public function __construct(
        protected EstadoDiariaService $estadoDiariaService
    ) {}

    public function index(): JsonResponse
    {
        $estados = $this->estadoDiariaService->getAll();
        return response()->json($estados);
    }

    public function store(StoreEstadoDiariaRequest $request): JsonResponse
    {
        $estado = $this->estadoDiariaService->create($request->validated());
        return response()->json([
            'mensaje' => 'Estado agregado correctamente',
            'estado'  => $estado,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $estado = $this->estadoDiariaService->findById($id);

        if (!$estado) {
            return response()->json(['mensaje' => 'Estado no encontrado'], 404);
        }

        return response()->json($estado);
    }

    public function update(UpdateEstadoDiariaRequest $request, int $id): JsonResponse
    {
        $estado = $this->estadoDiariaService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Estado actualizado correctamente',
            'estado'  => $estado,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->estadoDiariaService->delete($id);
        return response()->json(['mensaje' => 'Estado eliminado correctamente']);
    }
}
