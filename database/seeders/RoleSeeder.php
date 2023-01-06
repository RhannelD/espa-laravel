<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();

        $roles = [
            [
                'role' => ['name' => 'Super Admin'],
            ],
            [
                'role' => ['name' => 'College Dean'],
                'permissions' => [
                    'Dashboard Page',

                    'Program List',
                    'Program View',
                    'Program Create',
                    'Program Update',
                    'Program Delete',
                ],
            ],
            [
                'role' => ['name' => 'Program Chairperson'],
                'permissions' => [
                    'Dashboard Page',

                    'Course List',
                    'Course View',
                    'Course Create',
                    'Course Update',
                    'Course Delete',

                    'Curriculum List',
                    'Curriculum View',
                    'Curriculum Create',
                    'Curriculum Update',
                    'Curriculum Delete',
                    'Curriculum Duplicate',
                    'Curriculum Update Course',
                ],
            ],
        ];

        foreach ($roles as $role_data) {
            $role = Role::create($role_data['role']);

            foreach ($role_data['permissions'] ?? [] as $permission_value) {
                $role->givePermissionTo($permission_value);
            }
        }
    }

    public function createPermissions()
    {
        $permission_list = [
            'Dashboard' => [
                'Dashboard Page',
            ],
            'Course' => [
                'Course List',
                'Course View',
                'Course Create',
                'Course Update',
                'Course Delete',
            ],
            'Program' => [
                'Program List',
                'Program View',
                'Program Create',
                'Program Update',
                'Program Delete',
            ],
            'College' => [
                'College List',
                'College View',
                'College Create',
                'College Update',
                'College Delete',
            ],
            'Curriculum' => [
                'Curriculum List',
                'Curriculum View',
                'Curriculum Create',
                'Curriculum Update',
                'Curriculum Delete',
                'Curriculum Duplicate',
                'Curriculum Update Course',
            ],
            'Officer' => [
                'Officer List',
                'Officer View',
                'Officer Create',
                'Officer Update',
                'Officer Password Update',
                'Officer Role Permission Update',
                'Officer Delete',
            ],
            'Student' => [
                'Student List',
                'Student View',
                'Student Create',
                'Student Update',
                'Student Password Update',
                'Student Delete',
                'Student Curriculum View',
                'Student Curriculum Update',
                'Student Grade Update',
                'Student Grade Delete',
            ],
            'Role' => [
                'Role List',
                'Role View',
                'Role Create',
                'Role Update',
                'Role Delete',
            ],
            'Permission' => [
                'Permission List',
                'Permission Give',
            ],
        ];

        foreach ($permission_list as $group => $permissions) {
            foreach ($permissions as $permission_value) {
                $permission = Permission::create([
                    'name' => $permission_value,
                    'group' => $group,
                ]);
            }
        }
    }
}
