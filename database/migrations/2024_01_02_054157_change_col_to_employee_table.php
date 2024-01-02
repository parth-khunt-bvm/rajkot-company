<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->date('DOJ')->nullable()->change();
            $table->date('DOB')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('acc_holder_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('ifsc_number')->nullable()->change();
            $table->string('personal_email')->nullable()->change();
            $table->string('aadhar_card_number')->nullable()->change();
            $table->string('parents_name')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->decimal('experience', 16,4)->nullable()->change();
            $table->decimal('salary', 16,4)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            //
        });
    }
}
