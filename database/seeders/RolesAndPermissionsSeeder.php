<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $observer = Role::firstOrCreate(['name' => 'Observer']);


        $models = [
            'user',
            'role',
            'permission',
            'admin',
            'assessment',
            'assignment',
            'chapter',
            'ebook',
            'group',
            'image',
            'lesson',
            'material',
            'message',
            'observation',
            'observation',
            'observationHistory',
            'observationQuestion',
            'observer',
            'school',
            'stage',
            'student_assessment',
            'student',
            'teacher',
            'teacherClass',
            'teacherResource',
            'type',
            'unit',
        ];
        $crudActions = ['create', 'read', 'update', 'delete'];
        foreach ($models as $model) {
            foreach ($crudActions as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$model}"]);
            }
        }
       
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());
        
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor']);
        $readPermissions = Permission::where('name', 'like', 'read %')->get();
        $supervisorRole->syncPermissions($readPermissions);

        $this->command->info('Permissions and roles seeded successfully!');
    }
}
