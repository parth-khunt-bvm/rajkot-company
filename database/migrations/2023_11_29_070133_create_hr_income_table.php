<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_income', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('month_of');
            $table->string('remarks');
            $table->decimal('amount', 16,4);
            $table->integer('manager_id');
            $table->integer('payment_mode');
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
        Schema::dropIfExists('hr_income');
    }
}
