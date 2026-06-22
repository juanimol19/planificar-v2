<?php

namespace App\Http\Controllers;

use App\Http\Requests\Persona\UpdatePerfilRequest;
use App\Services\PersonaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function __construct(
        protected PersonaService $personaService
    ) {}

    public function show(Request $request): JsonResponse
    {
        $persona = $request->user()->persona;

        if (!$persona) {
            return response()->json(['mensaje' => 'Perfil no encontrado'], 404);
        }

        return response()->json($persona);
    }

    public function update(UpdatePerfilRequest $request): JsonResponse
    {
        $persona = $request->user()->persona;

        if (!$persona) {
            return response()->json(['mensaje' => 'Perfil no encontrado'], 404);
        }

        $persona = $this->personaService->update($persona->id, $request->validated());

        return response()->json([
            'mensaje' => 'Perfil actualizado correctamente',
            'persona' => $persona,
        ]);
    }
}