<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brand')->truncate();

        $brands = [
            [
                'brand_name' => 'HP',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'brand_name' => 'Dell',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'brand_name' => 'Lenova',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'brand_name' => 'Logitech',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'brand_name' => 'AOC',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'brand_name' => 'Acer',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]

        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
