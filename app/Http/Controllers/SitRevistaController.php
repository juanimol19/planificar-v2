<?php

namespace App\Http\Controllers;

use App\Http\Requests\SitRevista\StoreSitRevistaRequest;
use App\Http\Requests\SitRevista\UpdateSitRevistaRequest;
use App\Services\SitRevistaService;
use Illuminate\Http\JsonResponse;

class SitRevistaController extends Controller
{
    public function __construct(
        protected SitRevistaService $sitRevistaService
    ) {}

    public function index(): JsonResponse
    {
        $revistas = $this->sitRevistaService->getAll();
        return response()->json($revistas);
    }

    public function store(StoreSitRevistaRequest $request): JsonResponse
    {
        $revista = $this->sitRevistaService->create($request->validated());
        return response()->json([
            'mensaje'  => 'Situación de revista agregada correctamente',
            'revista'  => $revista,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $revista = $this->sitRevistaService->findById($id);

        if (!$revista) {
            return response()->json(['mensaje' => 'Situación de revista no encontrada'], 404);
        }

        return response()->json($revista);
    }

    public function update(UpdateSitRevistaRequest $request, int $id): JsonResponse
    {
        $revista = $this->sitRevistaService->update($id, $request->validated());
        return response()->json([
            'mensaje'  => 'Situación de revista actualizada correctamente',
            'revista'  => $revista,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->sitRevistaService->delete($id);
        return response()->json(['mensaje' => 'Situación de revista eliminada correctamente']);
    }
}
