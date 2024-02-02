<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_request', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('employee_id');
            $table->integer('manager_id');
            $table->text('reason')->nullable();
            $table->enum('leave_type',['0','1', '2', '3'])->default("0")->comment("0 for Present, 1 for absent, 2 for half day, 3 for sort leave");
            $table->enum('leave_status',['P','M', 'H'])->default("P")->comment("P for Pending, M for by manager approved, H for by hr approved");
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
        Schema::dropIfExists('leave_request');
    }
}
