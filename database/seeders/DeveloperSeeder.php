<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => "Developer",
            'last_name' => "Developer",
            'email' => "dev@bvminfotech.com",
            'password' => Hash::make('Dev@2024'),
            'userimage' => NUll,
            'user_type' => 0,
            'is_admin'=>'Y',
            'status' => 'A',
            'is_deleted' => 'N',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
    }
}
