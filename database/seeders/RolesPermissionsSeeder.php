<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        Role::create(['name' => 'user', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Permisos
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete users']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
