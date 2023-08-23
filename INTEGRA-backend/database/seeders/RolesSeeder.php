<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Super Admin' , 'guard_name' => 'api'],
            ['name' => 'Marketing Manager' , 'guard_name' => 'api'],
            ['name' => 'HR Manager' , 'guard_name' => 'api'],
            ['name' => 'Repository Manager' , 'guard_name' => 'api'],
        ]);
    }
}
