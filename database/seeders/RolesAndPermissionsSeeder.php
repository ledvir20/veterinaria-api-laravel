<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Borra la caché de permisos y roles gestionada por PermissionRegistrar.
         *
         * Forza que las autorizaciones (permisos/roles) se recarguen desde la base de datos
         * en la siguiente consulta. Útil tras ejecutar seeders o modificar permisos en tiempo
         * de ejecución para que los cambios sean efectivos inmediatamente.
         *
         * Nota: no elimina datos de la base de datos, solo limpia la caché interna manejada
         * por la librería (p. ej. Spatie\Permission).
         */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos
        $permisos = [
            'crear duenos',
            'ver duenos',
            'crear mascotas',
            'ver mascotas',
            'crear historiales',
            'ver historiales',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $veterinario = Role::firstOrCreate(['name' => 'veterinario']);
        $operador = Role::firstOrCreate(['name' => 'operador']);

        // Asignar permisos
        $admin->givePermissionTo(Permission::all());

        $veterinario->givePermissionTo([
            'ver duenos',
            'ver mascotas',
            'crear historiales',
            'ver historiales',
        ]);

        $operador->givePermissionTo([
            'crear duenos',
            'ver duenos',
            'crear mascotas',
            'ver mascotas',
        ]);
    }
}
