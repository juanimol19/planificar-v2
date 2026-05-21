<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
 /**
     * 👇 Este "trait" agrega al modelo User la capacidad de trabajar con tokens de acceso.
     * - Viene del paquete Laravel Sanctum.
     * - Permite crear tokens personales con $user->createToken('nombre').
     * - Cada token se guarda en la tabla personal_access_tokens.
     * - Podés listar todos los tokens del usuario con $user->tokens.
     * - Podés revocar un token con $user->currentAccessToken()->delete().
     * - Gracias a esto, tu API puede autenticar usuarios usando Authorization: Bearer <token>.
     *
     * En resumen: HasApiTokens convierte al modelo User en un "usuario autenticable por token",
     * lo que hace posible el login/logout con Bearer Tokens en tus controladores.
     */    
    use HasApiTokens;

    /**
     * 👇 Este "trait" agrega al modelo User la capacidad de manejar roles y permisos.
     * - Viene del paquete Spatie Laravel Permission.
     * - Permite asignar roles a los usuarios con $user->assignRole('admin').
     * - Permite verificar roles con $user->hasRole('admin').
     * - Permite asignar permisos directos con $user->givePermissionTo('edit articles').
     * - Permite verificar permisos con $user->can('edit articles').
     *
     * En resumen: HasRoles convierte al modelo User en un "usuario con roles y permisos",
     * lo que facilita la implementación de control de acceso basado en roles (RBAC) en tu aplicación.
     */
    use HasRoles;

    /**
     * Campos que se pueden asignar masivamente (mass assignment).
     * Ejemplo: User::create([...]) solo permitirá estos atributos.
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * Campos que se ocultan automáticamente cuando el modelo
     * se convierte a JSON o array (ej. en respuestas API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
/**
 * Definimos cómo se deben "castear" (convertir automáticamente)
 * ciertos atributos del modelo cuando se guardan o se leen.
 */
protected function casts(): array
{


    return [
        // 👇 Aquí indicamos que el campo 'password' debe ser tratado como 'hashed'.
        // Esto significa que:
        // 1. Cada vez que asignemos un valor a 'password', Laravel lo va a encriptar automáticamente con bcrypt.
        //    Ejemplo: $user->password = 'miClave123'; → se guarda como hash bcrypt en la BD.
        // 2. Cuando leamos el campo 'password', no se desencripta (porque los hashes no se pueden revertir),
        //    simplemente se devuelve el string encriptado.
        // 3. Nos evita tener que usar manualmente Hash::make() en cada asignación.
        //
        // ⚠️ Importante: este "cast" solo funciona en Laravel 10+,
        // donde se incorporó el tipo 'hashed' como opción nativa.
        'password' => 'hashed',
    ];
}
}
