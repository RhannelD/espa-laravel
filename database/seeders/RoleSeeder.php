<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $roles = [
            [
                'name' => 'Super Admin',
            ],
            [
                'name' => 'College Dean',
            ],
            [
                'name' => 'Program Chairperson',
            ],
        ];

        foreach ($roles as $role_data) {
            $role = Role::create($role_data);
        }
    }
}
