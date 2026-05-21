<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cargo\StoreCargoRequest;
use App\Http\Requests\Cargo\UpdateCargoRequest;
use App\Services\CargoService;
use Illuminate\Http\JsonResponse;

class CargosController extends Controller
{
    public function __construct(
        protected CargoService $cargoService
    ) {}

    public function index(): JsonResponse
    {
        $cargos = $this->cargoService->getAll();
        return response()->json($cargos);
    }

    public function store(StoreCargoRequest $request): JsonResponse
    {
        $cargo = $this->cargoService->create($request->validated());
        return response()->json([
            'mensaje' => 'Cargo agregado con éxito',
            'cargo'   => $cargo,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $cargo = $this->cargoService->findById($id);

        if (!$cargo) {
            return response()->json(['mensaje' => 'Cargo no encontrado'], 404);
        }

        return response()->json($cargo);
    }

    public function update(UpdateCargoRequest $request, int $id): JsonResponse
    {
        $cargo = $this->cargoService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Cargo actualizado correctamente',
            'cargo'   => $cargo,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cargoService->delete($id);
        return response()->json(['mensaje' => 'Cargo eliminado con éxito']);
    }
}
