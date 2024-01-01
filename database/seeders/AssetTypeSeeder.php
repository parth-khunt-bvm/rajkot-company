<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;
use DB;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asset')->truncate();

        $assets = [
            [
                'asset_type' => 'Laptop',
                'asset_code' => 'LP',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'Keyboard',
                'asset_code' => 'KB',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'Mouse',
                'asset_code' => 'MU',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'Moniter(screen)',
                'asset_code' => 'MO',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'CPU',
                'asset_code' => 'CP',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'Headphone',
                'asset_code' => 'HP',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'asset_type' => 'Webcam',
                'asset_code' => 'wc',
                'is_deleted' => 'N',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
