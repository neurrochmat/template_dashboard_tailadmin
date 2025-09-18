<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $root = Menu::firstOrCreate([
            'nama_menu' => 'Menu Manajemen',
            'url' => '#',
            'icon' => '',
            'parent_id' => '0',
        ], [
            'urutan' => 1,
            'tipe_menu' => 'be',
        ]);

        $dashboard = Menu::firstOrCreate([
            'nama_menu' => 'Dashboard',
            'url' => 'home',
            'icon' => 'fas fa-home',
            'parent_id' => (string) $root->id,
        ], [
            'urutan' => 1,
            'tipe_menu' => 'be',
        ]);

        $penggunaGroup = Menu::firstOrCreate([
            'nama_menu' => 'Manajemen Pengguna',
            'url' => '#',
            'icon' => 'fas fa-users-cog',
            'parent_id' => (string) $root->id,
        ], [
            'urutan' => 2,
            'tipe_menu' => 'be',
        ]);

        $menuUsers = Menu::firstOrCreate([
            'nama_menu' => 'Kelola Pengguna',
            'url' => 'manage-user',
            'parent_id' => (string) $penggunaGroup->id,
        ], [
            'urutan' => 1,
            'tipe_menu' => 'be',
        ]);

        $menuRoles = Menu::firstOrCreate([
            'nama_menu' => 'Kelola Role',
            'url' => 'manage-role',
            'parent_id' => (string) $penggunaGroup->id,
        ], [
            'urutan' => 2,
            'tipe_menu' => 'be',
        ]);

        $menuMenus = Menu::firstOrCreate([
            'nama_menu' => 'Kelola Menu',
            'url' => 'manage-menu',
            'parent_id' => (string) $penggunaGroup->id,
        ], [
            'urutan' => 3,
            'tipe_menu' => 'be',
        ]);

        // Ensure permissions have menu_id associated
        $this->attachPermissions($menuUsers->id, 'user');
        $this->attachPermissions($menuRoles->id, 'role');
        $this->attachPermissions($menuMenus->id, 'menu');

        // Backup Server section
        $backupRoot = Menu::firstOrCreate([
            'nama_menu' => 'Backup Server',
            'url' => '#',
            'icon' => '',
            'parent_id' => '0',
        ], [
            'urutan' => 3,
            'tipe_menu' => 'be',
        ]);

        $backupDb = Menu::firstOrCreate([
            'nama_menu' => 'Backup Database',
            'url' => 'backup-database',
            'icon' => 'fas fa-database',
            'parent_id' => (string) $backupRoot->id,
        ], [
            'urutan' => 1,
            'tipe_menu' => 'be',
        ]);

        $this->attachPermissions($backupDb->id, 'backup');

        // Attach menus to admin role using pivot table
        $menuIds = collect([$root->id, $dashboard->id, $penggunaGroup->id, $menuUsers->id, $menuRoles->id, $menuMenus->id, $backupRoot->id, $backupDb->id])
            ->unique();

        foreach ($menuIds as $mid) {
            DB::table('role_has_menus')->updateOrInsert([
                'menu_id' => $mid,
                'role_id' => $adminRole->id,
            ], []);
        }
    }

    private function attachPermissions(int $menuId, string $entity): void
    {
        foreach (['create', 'read', 'update', 'delete'] as $action) {
            Permission::updateOrCreate(
                ['name' => $action . '_' . $entity],
                ['menu_id' => $menuId]
            );
        }
    }
}
