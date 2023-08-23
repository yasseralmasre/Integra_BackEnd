<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarketingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaigns')->insert([
            'name'              => 'Loca',
            'description'       => 'Tech Campaign',
            'start_date'        => '2102-11-02',
            'end_date'          => '2122-11-06',
            'budget'            => '4000',
            'status'            => 'Pending',
            'expected_revenue'  => '7000',
            'actual_revenue'    => '10000',
        ]);

        DB::table('events')->insert([
            'name'              => 'goya',
            'place'             => 'Dubai Mall',
            'description'       => 'Big Event with some concerts',
            'type'              => 'concert',
            'cost'              => '3421',
            'campaign_id'       => '1',
            'expected_revenue'  => '7000',
            'actual_revenue'    => '10000',
        ]);

        DB::table('social_media')->insert([
            'blogger'           => 'Yasser',
            'type'              => 'Facebook',
            'way'               => 'Reels',
            'cost'              => '5000',
            'campaign_id'       => '1',
            'expected_revenue'  => '7000',
            'actual_revenue'    => '10000',
        ]);

        DB::table('tvs')->insert([
            'channel'            => 'Yasser',
            'time'               => '30',
            'cost'               => 'Reels',
            'cost'               => '5000',
            'advertising_period' => '50',
            'campaign_id'        => '1',
            'expected_revenue'   => '7000',
            'actual_revenue'     => '10000',
        ]);

        DB::table('customers')->insert([
            'name'    => 'Omar',
            'gender'  => 'Male',
            'age'     => '34',
            'address' => 'Kafarsose',
            'email'   => 'Omar@gmail.com',
            'phone'   => '0987564243',
        ]);

    }
}
