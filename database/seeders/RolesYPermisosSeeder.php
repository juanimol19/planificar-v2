<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

//php artisan db:seed --class=RolesYPermisosSeeder
class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiamos caché de permisos para evitar conflictos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Creamos permisos básicos

        // CRUD para personas
        Permission::firstOrCreate(['name' => 'crear personas']);
        Permission::firstOrCreate(['name' => 'editar personas']);
        Permission::firstOrCreate(['name' => 'borrar personas']);
        Permission::firstOrCreate(['name' => 'listar personas']);

        // CRUD para usuarios
        Permission::firstOrCreate(['name' => 'crear usuarios']);
        Permission::firstOrCreate(['name' => 'editar usuarios']);
        Permission::firstOrCreate(['name' => 'borrar usuarios']);
        Permission::firstOrCreate(['name' => 'listar usuarios']);

        // CRUD para planificaciones
        Permission::firstOrCreate(['name' => 'crear planificaciones']);
        Permission::firstOrCreate(['name' => 'editar planificaciones']);
        Permission::firstOrCreate(['name' => 'borrar planificaciones']);
        Permission::firstOrCreate(['name' => 'listar planificaciones']);

        // Estado de Planificaciones
        Permission::firstOrCreate(['name' => 'aprobar planificaciones']);
        Permission::firstOrCreate(['name' => 'rechazar planificaciones']);
        Permission::firstOrCreate(['name' => 'observar planificaciones']);

        // 3. Creamos roles y les asignamos permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all()); // todos los permisos

        $director = Role::firstOrCreate(['name' => 'director']);
        $director->syncPermissions([
            'crear personas', 'editar personas', 'listar personas',
            'aprobar planificaciones', 'rechazar planificaciones', 'observar planificaciones'
        ]);

        $docente = Role::firstOrCreate(['name' => 'docente']);
        $docente->syncPermissions([
            'listar planificaciones', 'crear planificaciones',
            'editar planificaciones', 'borrar planificaciones'
        ]);

        // 4. Creamos usuario root si no existe y le asignamos rol admin
        $root = User::firstOrCreate(
            ['email' => 'root@example.com'], // búsqueda por email
            [
                'name' => 'Root User',
                'password' => bcrypt('12345678'),
            ]
        );

        if (! $root->hasRole('admin')) {
            $root->assignRole('admin');
        }
    }
}