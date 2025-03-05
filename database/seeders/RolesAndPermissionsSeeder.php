<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $observer = Role::firstOrCreate(['name' => 'Observer']);

        // Define permissions
        $permissions = [
            'manage users',
            'create roles',
            'assign roles',
            'delete roles',
            'view reports'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all());
        $supervisor->givePermissionTo(['view reports']);
    }
}
