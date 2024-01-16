<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_slip', function (Blueprint $table) {
            $table->id();
            $table->integer('department');
            $table->integer('designation');
            $table->integer('employee');
            $table->integer('month');
            $table->integer('year');
            $table->date('pay_salary_date')->nullable();
            $table->decimal('basic_salary', 16,4);
            $table->integer('working_day');
            $table->integer('loss_of_pay');
            $table->decimal('house_rent_allow_pr', 16,4);
            $table->decimal('house_rent_allow', 16,4);
            $table->decimal('income_tax_pr', 16,4);
            $table->decimal('income_tax', 16,4);
            $table->decimal('pf_pr', 16,4);
            $table->decimal('pf', 16,4);
            $table->decimal('pt_pr', 16,4);
            $table->decimal('pt', 16,4);
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
        Schema::dropIfExists('salary_slip');
    }
}
