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

            foreach ($role_data['permissions']??[] as $permission_value) {
                $role->givePermissionTo($permission_value);
            }
        }
    }

    public function createPermissions()
    {
        $permission_list = [
            'User List',
            'User View',
            'User Create',
            'User Update',
            'User Update Password',
            'User Delete',

            'Course List',
            'Course View',
            'Course Create',
            'Course Update',
            'Course Delete',

            'Program List',
            'Program View',
            'Program Create',
            'Program Update',
            'Program Delete',

            'College List',
            'College View',
            'College Create',
            'College Update',
            'College Delete',

            'Curriculum List',
            'Curriculum View',
            'Curriculum Create',
            'Curriculum Update',
            'Curriculum Delete',
            'Curriculum Duplicate',
            'Curriculum Update Course',
        ];

        foreach ($permission_list as $permission_value) {
            $permission = Permission::create(['name' => $permission_value]);
        }
    }
}
