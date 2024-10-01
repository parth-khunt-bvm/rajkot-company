<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseDateToAssetMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_master', function (Blueprint $table) {
            $table->date('purchase_date')->after('asset_code')->nullable();
            $table->decimal('warranty_guarantee', 16, 4)->after('purchase_date')->nullable();
            $table->enum('agreement',['W','G','N'])->default('N')->comment("W for Warranty, G for Guarantee, N for None")->after('warranty_guarantee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_master', function (Blueprint $table) {
            $table->dropColumn('purchase_date');
            $table->dropColumn('warranty_guarantee');
            $table->dropColumn('agreement');
        });
    }
}
