<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['guard_name' => 'student', 'name' => 'student']);
        Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        Role::create(['guard_name' => 'admin', 'name' => 'supervisor']);

        Permission::create(['guard_name' => 'student', 'name' => 'create']);
        Permission::create(['guard_name' => 'student', 'name' => 'read']);

        Permission::create(['guard_name' => 'admin', 'name' => 'create']);
        Permission::create(['guard_name' => 'admin', 'name' => 'read']);
        Permission::create(['guard_name' => 'admin', 'name' => 'update']);
        Permission::create(['guard_name' => 'admin', 'name' => 'delete']);

        $studentRole = Role::findOrFail(1);
        $adminRole = Role::findOrFail(2);
        $spvRole = Role::findOrFail(3);

        $PermissonCreateStudent = Permission::findOrFail(1);
        $PermissonReadStudent = Permission::findOrFail(2);

        $PermissonCreateAdmin = Permission::findOrFail(3);
        $PermissonReadAdmin = Permission::findOrFail(4);
        $PermissonUpdateAdmin = Permission::findOrFail(5);
        $PermissonDeleteAdmin = Permission::findOrFail(6);

        $studentRole->givePermissionTo([$PermissonCreateStudent, $PermissonReadStudent]);
        $adminRole->givePermissionTo([$PermissonCreateAdmin, $PermissonReadAdmin, $PermissonUpdateAdmin, $PermissonDeleteAdmin]);
        $spvRole->givePermissionTo([$PermissonCreateAdmin, $PermissonReadAdmin]);
    }
}
