<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            DesignationSeeder::class,
            BranchSeeder::class,
            TechnologySeeder::class,
            AssetTypeSeeder::class,
            BrandSeeder::class,
            ManagerSeeder::class,
        ]);
    }
}
