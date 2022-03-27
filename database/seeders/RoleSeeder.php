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
        $role1 = Role::create(['name' => 'Administrador general']); //super admin
        $role2 = Role::create(['name' => 'Jefa de sub-departamento técnico']); //jefas de region
        $role3 = Role::create(['name' => 'Coordinador de sub-área']); //operador
        $role4 = Role::create(['name' => 'Técnico informatico']); //ti
        $role5 = Role::create(['name' => 'Coordinador de área']); //sub jefa de region
        /* Projects Module */
        Permission::create(['name' => 'proyectos', 'description' => 'Ver menú proyectos'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'proyectos.index', 'description' => 'Ver lista de proyectos'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'proyectos.create', 'description' => 'Crear nuevo proyecto'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'proyectos.edit', 'description' => 'Editar proyecto'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'proyectos.destroy', 'description' => 'Eliminar proyecto'])->syncRoles([$role1, $role2, $role4]);
        /* Report Module */
        Permission::create(['name' => 'informes.create', 'description' => 'Crear informe'])->syncRoles([
            $role1, $role2, $role3
        ]);
        Permission::create(['name' => 'reports-list', 'description' => 'Ver lista de informe de un proyecto'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'studies-list', 'description' => 'Ver lista de estudios de un proyecto'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'upload-reports', 'description' => 'Subir informes'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'show-informs', 'description' => 'Ver lista de informes'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'downloadFile', 'description' => 'Descargar archivos de los informes'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'deleteFile', 'description' => 'Eliminar archivos de los informes'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'deleteStudioDirectory', 'description' => 'Eliminar directorio de un estudio'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'deleteReportsDirectory', 'description' => 'Eliminar directorio de un reporte'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'report-edit', 'description' => 'Editar informe'])->syncRoles([$role1, $role2, $role3, $role4]);
        /* Reports Module */
        Permission::create(['name' => 'show.reports', 'description' => 'Ver reportes'])->syncRoles([$role1, $role2, $role4]);
        /* Config Module */
        Permission::create(['name' => 'config', 'description' => 'Ver menú de configuración'])->syncRoles([$role1, $role4]);
    }
}
