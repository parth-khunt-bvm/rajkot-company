<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('department');
            $table->date('DOJ');
            $table->string('gmail')->nullable();
            $table->string('password')->nullable();
            $table->string('slack_password')->nullable();
            $table->date('DOB');
            $table->string('bank_name');
            $table->string('acc_holder_name');
            $table->bigInteger('account_number');
            $table->string('ifsc_number');
            $table->string('personal_email');
            $table->string('pan_number')->nullable();
            $table->integer('aadhar_card_number');
            $table->string('parents_name');
            $table->string('personal_number')->nullable();
            $table->string('google_pay_number')->nullable();
            $table->string('emergency_number')->nullable();
            $table->text('address');
            $table->decimal('experience', 16,4);
            $table->string('hired_by');
            $table->decimal('salary', 16,4);
            $table->date('stipend_from')->nullable();
            $table->date('bond_last_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('last_date')->nullable();
            $table->string('cancel_cheque')->nullable();
            $table->string('bond_file')->nullable();
            $table->text('trainee_performance')->nullable();
            $table->enum('status',['A','I'])->default("A")->comment("A for Active, I for not Inactive");
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
        Schema::dropIfExists('employee');
    }
}
