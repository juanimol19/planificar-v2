<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curso\StoreCursoRequest;
use App\Http\Requests\Curso\UpdateCursoRequest;
use App\Services\CursoService;
use Illuminate\Http\JsonResponse;

class CursosController extends Controller
{
    public function __construct(
        protected CursoService $cursoService
    ) {}

    public function index(): JsonResponse
    {
        $cursos = $this->cursoService->getAll();
        return response()->json($cursos);
    }

    public function store(StoreCursoRequest $request): JsonResponse
    {
        $curso = $this->cursoService->create($request->validated());
        return response()->json([
            'mensaje' => 'Curso creado exitosamente',
            'curso'   => $curso,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $curso = $this->cursoService->findById($id);

        if (!$curso) {
            return response()->json(['mensaje' => 'Curso no encontrado'], 404);
        }

        return response()->json($curso);
    }

    public function update(UpdateCursoRequest $request, int $id): JsonResponse
    {
        $curso = $this->cursoService->update($id, $request->validated());
        return response()->json([
            'mensaje' => 'Curso actualizado exitosamente',
            'curso'   => $curso,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cursoService->delete($id);
        return response()->json(['mensaje' => 'Curso eliminado exitosamente']);
    }
}
