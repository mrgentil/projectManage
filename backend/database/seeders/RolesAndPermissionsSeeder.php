<?php

// database/seeders/RolesAndPermissionsSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user.create', 'user.edit', 'user.delete',
            'department.create', 'department.edit', 'department.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);

        // Attribuer toutes les permissions à l'admin
        $admin->permissions()->sync(Permission::pluck('id'));

        // Manager a moins de permissions
        $manager->permissions()->sync(
            Permission::whereIn('name', ['user.edit', 'department.edit'])->pluck('id')
        );
    }
}
