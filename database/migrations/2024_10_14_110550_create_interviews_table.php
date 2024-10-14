<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->bigIncrements('interview_id');
            $table->date('schedule_date');
            $table->string('name');
            $table->string('mobile_no');
            $table->integer('technology');
            $table->integer('designation');
            $table->string('description')->nullable();
            $table->string('location');
            $table->decimal('experience', 8, 2)->comment('In months');
            $table->decimal('current_salary', 8, 2)->comment('Monthly');
            $table->decimal('expected_salary', 8, 2)->comment('Monthly');
            $table->integer('notice_period')->comment('In days');
            $table->text('reason_for_change');
            $table->string('resume')->nullable();
            $table->dateTime('hr_round_date_time')->nullable();
            $table->enum('hr_round_status', ['P', 'S', 'A', 'R'])->comment('P For pending, S for scheduled, A for passed, R for rejected')->default('P');
            $table->text('hr_round_reason')->nullable();
            $table->dateTime('team_leader_date_time')->nullable();
            $table->enum('team_leader_status', ['P', 'S', 'A', 'R'])->comment('P For pending, S for scheduled, A for passed, R for rejected')->default('P');
            $table->text('team_leader_reason')->nullable();
            $table->dateTime('practical_date_time')->nullable();
            $table->enum('practical_status', ['P', 'S', 'C', 'A', 'R'])->comment('P For pending, S for scheduled, C for Checking, A for passed, R for rejected')->default('P');
            $table->text('practical_reason')->nullable();
            $table->integer('allocated_interviewer')->nullable();
            $table->enum('final_status', ['P', 'S', 'R'])->comment('P For pending, S Selected, R for rejected')->default('P');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
