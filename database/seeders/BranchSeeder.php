<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch')->truncate();

        $branchs = [
            [
                'branch_name' => 'Silver business point - BVM(1)',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'branch_name' => 'Katargam - BVM(2)',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'branch_name' => 'Rajkot - BVM(3)',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'branch_name' => 'HK Apps - BVM(4)',
                'status' => 'A',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]

        ];

        foreach ($branchs as $branch) {
            Branch::create($branch);
        }
    }
}
