<?php

namespace Database\Seeders;

use App\Models\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Admin',
            ],
            [
                'role_name' => 'Dip Skin Cancer',
            ],
            [
                'role_name' => 'Cosmetic Medical Procedures',
            ],
            [
                'role_name' => 'Operational Manager',
            ],
            [
                'role_name' => 'Paramedical Aestheticiand',
            ],
            [
                'role_name' => 'Cosmetic Nurse',
            ]
        ];

        foreach( $roles as $role )
        {
            UserRoles::create($role);
        }
    }
}
