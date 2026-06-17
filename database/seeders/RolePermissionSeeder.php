<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permisos generales (Director) ──────────────────────────
        $permisosDirector = [
            'ver personas',        'crear personas',        'editar personas',        'eliminar personas',
            'ver cargos',          'crear cargos',          'editar cargos',          'eliminar cargos',
            'ver sit-revista',     'crear sit-revista',     'editar sit-revista',     'eliminar sit-revista',
            'ver areas',           'crear areas',           'editar areas',           'eliminar areas',
            'ver cursos',          'crear cursos',          'editar cursos',          'eliminar cursos',
            'ver cursados',        'crear cursados',        'editar cursados',        'eliminar cursados',
            'ver persona-cargos',  'crear persona-cargos',  'editar persona-cargos',  'eliminar persona-cargos',
            'ver persona-cargo-cursado', 'crear persona-cargo-cursado', 'editar persona-cargo-cursado', 'eliminar persona-cargo-cursado',
            'ver planificacion-anual',   'crear planificacion-anual',   'editar planificacion-anual',   'eliminar planificacion-anual',
            'ver planificacion-diaria',  'crear planificacion-diaria',  'editar planificacion-diaria',  'eliminar planificacion-diaria',
            'ver estados-anual',         'crear estados-anual',         'editar estados-anual',         'eliminar estados-anual',
            'ver estados-diaria',        'crear estados-diaria',        'editar estados-diaria',        'eliminar estados-diaria',
            'ver persona-cargos-detalle',
        ];

        // ── Permisos específicos (Docente) ─────────────────────────
        $permisosDocente = [
            'ver planificacion-anual',   'crear planificacion-anual',   'editar planificacion-anual',   'eliminar planificacion-anual',
            'ver planificacion-diaria',  'crear planificacion-diaria',  'editar planificacion-diaria',  'eliminar planificacion-diaria',
            'ver estados-anual',         'crear estados-anual',         'editar estados-anual',         'eliminar estados-anual',
            'ver estados-diaria',        'crear estados-diaria',        'editar estados-diaria',        'eliminar estados-diaria',
        ];

        // Crear todos los permisos
        foreach ($permisosDirector as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ── Crear roles y asignar permisos ─────────────────────────
        $director = Role::firstOrCreate(['name' => 'director']);
        $director->syncPermissions($permisosDirector);

        $docente = Role::firstOrCreate(['name' => 'docente']);
        $docente->syncPermissions($permisosDocente);

        // ── Nuevos roles con permisos de director ──────────────────
        $vicedirector = Role::firstOrCreate(['name' => 'vicedirector']);
        $vicedirector->syncPermissions($permisosDirector);

        $secretario = Role::firstOrCreate(['name' => 'secretario']);
        $secretario->syncPermissions($permisosDirector);
    }
}