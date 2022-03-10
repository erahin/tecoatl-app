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
        /* -------------------------------------------------------------------------- */
        /*                                    Roles                                   */
        /* -------------------------------------------------------------------------- */
        $role1 = Role::create(['name' => 'Super-user']); //super admin
        $role2 = Role::create(['name' => 'Admin']); //jefas de region
        $role3 = Role::create(['name' => 'Operator']); //estudios
        /* -------------------------------------------------------------------------- */
        /*                            Super User Permission                           */
        /* -------------------------------------------------------------------------- */
        /* Home */
        Permission::create(['name' => 'home'])->syncRoles([$role1, $role2, $role3]);
        /* Users Module */
        Permission::create(['name' => 'usuarios.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.destroy'])->syncRoles([$role1]);
        /* Studies Module */
        Permission::create(['name' => 'estudios.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'estudios.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'estudios.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'estudios.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'estudios.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'estudios.destroy'])->syncRoles([$role1]);
        /* Regions Module */
        Permission::create(['name' => 'regiones.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'regiones.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'regiones.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'regiones.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'regiones.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'regiones.destroy'])->syncRoles([$role1]);
        /* Projects Module */
        Permission::create(['name' => 'proyectos.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'proyectos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'proyectos.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'proyectos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'proyectos.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'proyectos.destroy'])->syncRoles([$role1, $role2]);
        /* Report Module */
        Permission::create(['name' => 'informes.store'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'informes.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'reports-list'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'upload-reports'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'show-informs'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'downloadFile'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'deleteFile'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'deleteStudioDirectory'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'deleteReportsDirectory'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'report-edit'])->syncRoles([$role1, $role2, $role3]);
    }
}
