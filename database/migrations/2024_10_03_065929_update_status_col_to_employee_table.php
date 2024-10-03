<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE employee MODIFY COLUMN status ENUM('W', 'L', 'S') DEFAULT 'W' COMMENT 'W for Working, L for Left, S for Semi-left'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE employee MODIFY COLUMN status ENUM('W', 'L') DEFAULT 'W' COMMENT 'W for Working, L for Left'");
    }
}
