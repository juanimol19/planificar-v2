<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoAnual\StoreEstadoAnualRequest;
use App\Http\Requests\EstadoAnual\UpdateEstadoAnualRequest;
use App\Services\EstadoAnualService;
use Illuminate\Http\JsonResponse;

class EstadosAnualController extends Controller
{
    public function __construct(
        protected EstadoAnualService $estadoAnualService
    ) {}

    public function index(): JsonResponse
    {
        $estados = $this->estadoAnualService->getAll();
        return response()->json($estados);
    }

    public function store(StoreEstadoAnualRequest $request): JsonResponse
    {
        $estado = $this->estadoAnualService->create($request->validated());
        return response()->json([
            'mensaje' => 'Registro creado correctamente',
            'estado'  => $estado,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $estado = $this->estadoAnualService->findById($id);

        if (!$estado) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        }

        return response()->json($estado);
    }

    public function update(UpdateEstadoAnualRequest $request, int $id): JsonResponse
    {
        $estado = $this->estadoAnualService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Registro actualizado correctamente',
            'estado'  => $estado,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->estadoAnualService->delete($id);
        return response()->json(['mensaje' => 'Registro eliminado correctamente']);
    }
}
