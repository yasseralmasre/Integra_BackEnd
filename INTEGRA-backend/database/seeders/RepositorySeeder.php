<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepositorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribute_groups')->insert([
            'name' => 'camera',
        ]);

        DB::table('attributes')->insert([
            'name'     => 'color',
            'type'     => 'select',
            'values'   => '["red","blue"]',
            'group_id' => '1',
        ]);

        DB::table('categories')->insert([
            'name' => 'tech',
        ]);

        DB::table('suppliers')->insert([
            'name'         => 'Amro',
            'address'      => 'Mazraa',
            'email'        => 'Amro@gmail.com',
            'phone_number' => '0932398765',
        ]);

        DB::table('products')->insert([
            'name'              => 'canon-343',
            'description'       => 'Very good camera',
            'price'             => '994',
            'quantity_in_stock' => '100',
            'category_id'       => '1',
            'supplier_id'       => '1',
        ]);

        DB::table('product_details')->insert([
            'details'            => '{"color":"red"}',
            'stock'              => '34',
            'product_id'         => '1',
            'attribute_group_id' => '1',
            'product_id'        => '1',
        ]);

        DB::table('exports')->insert([
            'name'         => 'kola',
            'date'         => '2023-07-19',
            'total_amount' => '1',
            'customer_id'  => '1',
            'employee_id'  => '1',
        ]);

        DB::table('imports')->insert([
            'name'          => 'joga',
            'date'          => '2023-07-19',
            'total_amount'  => '1',
            'supplier_id'   => '1',
            'employee_id'   => '1',
        ]);

    }
}
