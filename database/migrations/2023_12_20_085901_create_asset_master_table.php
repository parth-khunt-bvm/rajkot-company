<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_master', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('asset_id');
            $table->integer('brand_id');
            $table->integer('branch_id');
            $table->text('description');
            $table->text('status');
            $table->integer('price');
            $table->enum('is_deleted',['Y','N'])->default("N")->comment("Y for deleted, N for not deleted");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_master');
    }
}
