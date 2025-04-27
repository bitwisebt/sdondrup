<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@admin.com',
            'password'=>bcrypt('password'),
            'email_verified_at' => Carbon::now(),
            'role' => 1,
            'flag' => 'C'
        ]);

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         $permissions = [
            'User management access',
            'Permission access',
            'Role create',
            'Role edit',
            'Role access',
            'User create',
            'User edit',
            'User delete',
            'User restore',
            'User delete forever',
            'User access',
            'Mapping access',
            'Department create',
            'Department edit',
            'Department delete',
            'Department restore',
            'Department delete forever',
            'Department access',
            'Designation create',
            'Designation edit',
            'Designation delete',
            'Designation restore',
            'Designation delete forever',
            'Designation access',
            'Student create',
            'Student edit',
            'Student delete',
            'Student restore',
            'Student delete forever',
            'Student access',
            'Document create',
            'Document edit',
            'Document delete',
            'Document restore',
            'Document delete forever',
            'Document access',
            'Bank create',
            'Bank edit',
            'Bank delete',
            'Bank restore',
            'Bank delete forever',
            'Bank access',
            'EmployeeType create',
            'EmployeeType edit',
            'EmployeeType delete',
            'EmployeeType restore',
            'EmployeeType delete forever',
            'EmployeeType access',
            
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        $super_admin_role = Role::create(['name' => 'System Administrator']);
        //Assigning Role
        $admin->assignRole($super_admin_role);

        //Assigning Permission to Role
        foreach ($permissions as $superadminpermission)   {
            $super_admin_role->givePermissionTo($superadminpermission);
        }

       
    }
}
