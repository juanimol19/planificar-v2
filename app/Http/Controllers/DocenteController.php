<?php

namespace App\Http\Controllers;

use App\Http\Requests\Docente\CrearDocenteRequest;
use App\Services\DocenteService;
use Illuminate\Http\JsonResponse;

class DocenteController extends Controller
{
    public function __construct(
        protected DocenteService $docenteService
    ) {}

    public function store(CrearDocenteRequest $request): JsonResponse
    {
        $resultado = $this->docenteService->crearDocente($request->validated());

        return response()->json([
            'mensaje'  => 'Docente registrado correctamente',
            'docente'  => $resultado,
        ], 201);
    }
}