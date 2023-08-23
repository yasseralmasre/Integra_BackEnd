<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('departments')->insert([
            'name' => 'Super Admin'
        ]);

        DB::table('employees')->insert([
            'firstName'    => 'Super Admin',
            'lastName'     => 'Super Admin',
            'dateOfBrith'  => '2102-11-02',
            'gender'       => 'male',
            'address'      => 'lol',
            'email'        => 'Super_Admin@gmail.com',
            'phone'        => '1',
            'dateOfHire'   => '2102-11-02',
            'salary'       => '1',
            'supervisorId' => '1',
            'status'       => 'Actual',
            'department_id' => '1',
        ]);

        DB::table('employee_certificates')->insert([
            'employee_id' => '1',
            'name'        => 'ILTES',
            'level'       => '7/9',
        ]);

        DB::table('employee_educations')->insert([
            'employee_id'      => '1',
            'specialization'   => 'IT',
            'degree'           => 'Good',
            'grantingBy'       => 'Grand Comapany',
            'graduationDate'   => '2023-07-19',
        ]);

        DB::table('employee_performances')->insert([
            'employee_id'       => '1',
            'performanceRating' => 'Nice',
            'comments'          => 'Nice work',
            'reviewDate'        => '2023-07-19',
        ]);

        DB::table('employee_vacations')->insert([
            'employee_id'       => '1',
            'startDate'         => '2023-07-19',
            'endDate'           => '2024-08-19',
            'typeOfVacation'    => 'Mounthly',
            'reasonOfVacation'  => 'Travel',
            'status'            => 'denied',
        ]);

    }
}
