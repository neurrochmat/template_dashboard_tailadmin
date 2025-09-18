<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'read_user',
            'create_user',
            'update_user',
            'delete_user',
            'read_role',
            'create_role',
            'update_role',
            'delete_role',
            'read_menu',
            'create_menu',
            'update_menu',
            'delete_menu',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Create admin role
    $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);

        // Assign all permissions to admin
        $adminRole->syncPermissions($permissions);

        // Create user role
    $userRole = Role::firstOrCreate(['name' => 'warga', 'guard_name' => 'api']);

        // Create collector role
    $collectorRole = Role::firstOrCreate(['name' => 'collector', 'guard_name' => 'api']);
    }
}
