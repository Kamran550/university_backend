<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin rolunun ID-si alınır
        $adminRoleId = Role::where('name', 'admin')->value('id');

        User::create([
            'name'      => 'System',
            'surname'   => 'Administrators',
            'username'  => 'admin',          // daxil olmaq üçün
            'email'     => 'admin@eipu.edu.az',
            'password'  => Hash::make('password'), // to change the password, send an email
            'phone'     => '0000000000',
            'role_id'   => $adminRoleId,
        ]);
    }

}
