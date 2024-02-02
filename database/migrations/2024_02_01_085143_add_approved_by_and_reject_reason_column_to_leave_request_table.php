<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedByAndRejectReasonColumnToLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_request', function (Blueprint $table) {
            $table->enum('leave_status',['P','R','A'])->default("P")->comment("P for Pending, R for rejected, A for approved")->after('leave_type');
            $table->integer('approved_by')->nullable()->after('leave_status');
            $table->date('approved_date')->after('approved_by')->nullable();
            $table->text('reject_reason')->nullable()->after('approved_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_request', function (Blueprint $table) {
            //
        });
    }
}
