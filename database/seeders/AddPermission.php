<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve existing permissions
        $existingPermissions = Permission::pluck('name')->toArray();

        // Define new permissions
        $newPermissions = [
            'Report Employee',
            'Report Student',
            'Report Accounting',
            'Report Commission',
            // Add more new permissions as needed
        ];

        // Merge existing and new permissions
        $permissionsToCreate = array_diff($newPermissions, $existingPermissions);

        // Create new permissions
        foreach ($permissionsToCreate as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
