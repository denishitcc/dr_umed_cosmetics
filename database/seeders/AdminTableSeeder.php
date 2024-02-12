<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'id'                    => 1,
            'first_name'            => 'Umed',
            'last_name'             => 'Shekhavat',
            'email'                 => 'admin@gmail.com',
            'password'              => Hash::make('12345678'),
            'role_type'             => UserRoles::find(1)->role_name,
            'created_at' 	        => Carbon::now()->toDateTimeString(),
            'updated_at' 	        => Carbon::now()->toDateTimeString(),
            'email_verified_at'     => Carbon::now()->toDateTimeString()
        ]);
    }
}
