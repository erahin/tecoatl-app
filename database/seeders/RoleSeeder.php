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
        $role1 = Role::create(['name' => 'Técnico informático']); //super admin ahora ti
        $role2 = Role::create(['name' => 'Jefa de sub-departamento técnico']); //jefas de region
        $role3 = Role::create(['name' => 'Coordinador de subárea']); //operador
        $role4 = Role::create(['name' => 'Directivo']); //ti ahora directivo
        // $role5 = Role::create(['name' => 'Coordinador de área']); //sub jefa de region
        $role6 = Role::create(['name' => 'Jefa administrativa']);
        $role7 = Role::create(['name' => 'Jefa subadministrativa']);
        $role8 = Role::create(['name' => 'Jefa sublegal']);
        /* -------------------------------------------------------------------------- */
        /*                                 Permission                                 */
        /* -------------------------------------------------------------------------- */
        /* Projects Module */
        Permission::create(['name' => 'proyectos', 'description' => 'Ver menú proyectos'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'proyectos.index', 'description' => 'Ver lista de proyectos'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'proyectos.create', 'description' => 'Crear nuevo proyecto'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'proyectos.edit', 'description' => 'Editar proyecto'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'proyectos.destroy', 'description' => 'Eliminar proyecto'])->syncRoles([$role1, $role2, $role4]);
        /* Report Module */
        Permission::create(['name' => 'informes.create', 'description' => 'Crear informe'])->syncRoles([
            $role1, $role2, $role3, $role4
        ]);
        Permission::create(['name' => 'reports-list', 'description' => 'Ver lista de informe de un proyecto'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'studies-list', 'description' => 'Ver lista de estudios de un proyecto'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'upload-reports', 'description' => 'Crear informes'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'report-edit', 'description' => 'Editar informe'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'uploadFileReport', 'description' => 'Subir archivos de un informe'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'show-informs', 'description' => 'Ver lista de informes'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'downloadFile', 'description' => 'Descargar archivos de los informes'])->syncRoles([$role1, $role2, $role3, $role4, $role8]);
        Permission::create(['name' => 'deleteFile', 'description' => 'Eliminar archivos de los informes'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'deleteStudioDirectory', 'description' => 'Eliminar directorio de un estudio'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'deleteReportsDirectory', 'description' => 'Eliminar directorio de un informe'])->syncRoles([$role1, $role2, $role4]);

        /* Reports Module */
        Permission::create(['name' => 'show.reports', 'description' => 'Ver reportes'])->syncRoles([$role1, $role2, $role4]);
        /* Config Module */
        Permission::create(['name' => 'config.show', 'description' => 'Ver menú de configuración'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'config.ti', 'description' => 'Ver opciones de configuración'])->syncRoles([$role1]);
        Permission::create(['name' => 'config.executive', 'description' => 'Ver opción directiva'])->syncRoles([$role1, $role4]);
        /* Administrative Module */
        Permission::create(['name' => 'departaments.show', 'description' => 'Ver menú de departamentos'])->syncRoles([
            $role1, $role4, $role6, $role7, $role8
        ]);
        // First nivel //
        Permission::create(['name' => 'administrativos.index', 'description' => 'Ver lista de departamentos'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'administrativos.create', 'description' => 'Crear un nuevo departamento'])->syncRoles([$role1, $role6, $role4]);
        Permission::create(['name' => 'administrativos.edit', 'description' => 'Editar departamento'])->syncRoles([$role1, $role6, $role4]);
        Permission::create(['name' => 'administrativos.destroy', 'description' => 'Eliminar departamento'])->syncRoles([$role1, $role6, $role4]);
        Permission::create(['name' => 'createFolder', 'description' => 'Crear una carpeta administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'folderList', 'description' => 'Ver lista de carpetas administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        // Second nivel //
        Permission::create(['name' => 'showFormUploadFile', 'description' => 'Subir archivos a carpeta administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'fileList', 'description' => 'Ver lista de archivos de una carpeta administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'deleteFolder', 'description' => 'Eliminar carpeta administrativa'])->syncRoles([$role1, $role6]);
        // Third level //
        Permission::create(['name' => 'operFile', 'description' => 'Abrir archivo de una carpeta administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'downloadFileFolder', 'description' => 'Descargar archivo de una carpeta administrativa'])->syncRoles([$role1, $role6, $role7, $role4]);
        Permission::create(['name' => 'deleteFileFolder', 'description' => 'Eliminar archivo de una carpeta administrativa'])->syncRoles([$role1, $role6, $role4]);
        // /* Legal Module */
        Permission::create(['name' => 'legal.index', 'description' => 'Ver lista de departamentos legales'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.create', 'description' => 'Crear un nuevo departamento legal'])->syncRoles([$role4, $role1]);
        Permission::create(['name' => 'legal.edit', 'description' => 'Editar departamento legal'])->syncRoles([$role4, $role1]);
        Permission::create(['name' => 'legal.destroy', 'description' => 'Eliminar un departamento legal'])->syncRoles([$role4, $role1]);
        Permission::create(['name' => 'legal.folder-list', 'description' => 'Ver lista de carpetas legales'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.create-subfolder', 'description' => 'Crear una carpeta legal'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.createUpload', 'description' => 'Subir archivos a una carpeta legal'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.fileList', 'description' => 'Listar archivos de una carpeta legal'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.destroy-folder', 'description' => 'Eliminar una carpeta legal'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'legal.download', 'description' => 'Descargar archivo de una carpeta legal'])->syncRoles([$role1, $role4, $role8]);
        Permission::create(['name' => 'legal.deleteFile', 'description' => 'Eliminar archivo de una carpeta legal'])->syncRoles([$role1, $role4]);
        /* Public Module */
        Permission::create(['name' => 'publico.index', 'description' => 'Ver lista de carpetas públicas'])->syncRoles([$role1, $role2, $role3, $role4, $role6, $role7, $role8]);
        Permission::create(['name' => 'createFolderPublic', 'description' => 'Crear una carpeta pública'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'uploadFileForm', 'description' => 'Subir archivos a una carpeta pública'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'publicFilesList', 'description' => 'Listar archivos de una carpeta pública'])->syncRoles([$role1, $role2, $role3, $role4, $role6, $role7, $role8]);
        Permission::create(['name' => 'publico.destroy', 'description' => 'Eliminar una carpeta pública'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'downloadPublicFile', 'description' => 'Descargar archivo de una carpeta pública'])->syncRoles([$role1, $role2, $role3, $role4, $role6, $role7, $role8]);
        Permission::create(['name' => 'deletePublicFile', 'description' => 'Eliminar archivo de una carpeta pública'])->syncRoles([$role1, $role4]);
    }
}
