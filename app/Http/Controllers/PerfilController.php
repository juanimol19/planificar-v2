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
    $persona = $request->user()->persona?->load([
        'personaCargos.personaCargoCursados'
    ]);

    if (!$persona) {
        return response()->json(['mensaje' => 'Perfil no encontrado'], 404);
    }

    $personaCargoCursadoId = $persona->personaCargos->first()
        ?->personaCargoCursados->first()
        ?->id;

    return response()->json([
        'persona'                  => $persona,
        'persona_cargo_cursado_id' => $personaCargoCursadoId,
    ]);
}

    public function update(UpdatePerfilRequest $request): JsonResponse
    {
        $user = $request->user();
        $persona = $user->persona;

        if (!$persona) {
            return response()->json(['mensaje' => 'Perfil no encontrado'], 404);
        }

        $persona = $this->personaService->update($persona->id, $request->validated());

        // Sincronizar users.name si vienen nombres o apellidos
        if ($request->has('nombres') || $request->has('apellidos')) {
            $nombres   = $persona->nombres ?? $user->name;
            $apellidos = $persona->apellidos ?? '';
            $user->name = trim("{$nombres} {$apellidos}");
            $user->save();
        }

        return response()->json([
            'mensaje' => 'Perfil actualizado correctamente',
            'persona' => $persona,
            'name'    => $user->name,
        ]);
    }
}