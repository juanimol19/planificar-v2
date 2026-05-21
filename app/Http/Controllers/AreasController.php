<?php

namespace App\Http\Controllers;

use App\Http\Requests\Area\StoreAreaRequest;
use App\Http\Requests\Area\UpdateAreaRequest;
use App\Services\AreaService;
use Illuminate\Http\JsonResponse;

class AreasController extends Controller
{
    public function __construct(
        protected AreaService $areaService
    ) {}

    public function index(): JsonResponse
    {
        $areas = $this->areaService->getAll();
        return response()->json($areas);
    }

    public function store(StoreAreaRequest $request): JsonResponse
    {
        $area = $this->areaService->create($request->validated());
        return response()->json([
            'mensaje' => 'Área creada correctamente',
            'area'    => $area,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $area = $this->areaService->findById($id);

        if (!$area) {
            return response()->json(['mensaje' => 'Área no encontrada'], 404);
        }

        return response()->json($area);
    }

    public function update(UpdateAreaRequest $request, int $id): JsonResponse
    {
        $area = $this->areaService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Área actualizada correctamente',
            'area'    => $area,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->areaService->delete($id);
        return response()->json(['mensaje' => 'Área eliminada correctamente']);
    }
}
