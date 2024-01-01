<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manager')->truncate();

        DB::table('manager')->insert([
            'manager_name' => 'Pankaj Sir',
            'status' => 'A',
            'is_deleted' => 'N',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);

        DB::table('manager')->insert( [
            'manager_name' => 'Vinit Sir',
            'status' => 'A',
            'is_deleted' => 'N',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
    }
}
