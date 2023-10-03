<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenue', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('received_month');
            $table->smallInteger('month_of');
            $table->string('remarks');
            $table->decimal('amount', 8,4);
            $table->integer('manager_id');
            $table->integer('technology_id');
            $table->string('bank_name');
            $table->string('holder_name');
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
        Schema::dropIfExists('revenue');
    }
}
