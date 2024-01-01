<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;
use DB;
class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('technology')->truncate();


        $technologies = [
            [
                'technology_name' => 'Laravel',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'RecatJs',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'NodeJs',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'Android',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'Ui/Ux',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'BDE',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'QA',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'HR',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'CEO',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'VueJs',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'technology_name' => 'Python',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]



        ];

        foreach ($technologies as $technology) {
            Technology::create($technology);
        }
    }
}
