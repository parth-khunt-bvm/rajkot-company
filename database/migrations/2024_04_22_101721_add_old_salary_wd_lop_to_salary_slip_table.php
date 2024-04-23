<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldSalaryWdLopToSalarySlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_slip', function (Blueprint $table) {
            $table->decimal('old_basic_salary', 16,4)->nullable()->after('loss_of_pay');
            $table->integer('old_working_day')->nullable()->after('old_basic_salary');
            $table->integer('old_loss_of_pay')->nullable()->after('old_working_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_slip', function (Blueprint $table) {
            //
        });
    }
}
