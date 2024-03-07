<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_request', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->enum('request_type',['1','2','3','4'])->comment("1 for Personal Info, 2 for Bank Info, 3 for Parent Info, 4 for Company Info");
            $table->text('data');
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
        Schema::dropIfExists('change_request');
    }
}
