<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('year');
            $table->integer('employee_id');
            $table->integer('technology_id');
            $table->decimal('present_days', 16,4);
            $table->integer('half_leaves');
            $table->integer('full_leaves');
            $table->string('paid_leaves_details');
            $table->decimal('total_days', 16,4)->default(0.0000);
            $table->enum('salary_counted',['Y','N'])->default("Y")->comment("Y for Yes, N for No")->nullable();
            $table->date('paid_date')->nullable();
            $table->string('salary_status')->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('counter');
    }
}
