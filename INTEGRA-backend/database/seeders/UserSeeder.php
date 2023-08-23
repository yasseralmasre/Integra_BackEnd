<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullName'   => 'Super Admin',
            'username'   => 'Super Admin',
            'email'      => 'Super_Admin@gmail.com',
            'password'   => Hash::make('Admin12345'),
            'employee_id'   => '1',
        ]);


    }
}
