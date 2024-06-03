<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-website',
            'view-website',
            'update-website',
            'delete-website',
            'bulk-delete-website',

        ];

        $permissions = collect($permissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'api'];
        });

        Permission::insert($permissions->toArray());

        Role::firstOrCreate(['name' => 'website_worker'])
            ->givePermissionTo(['create-website',
                'view-website',
                'update-website',
                'delete-website',
                'bulk-delete-website',]);

        Role::firstOrCreate(['name' => 'super-admin']);

    }
}
