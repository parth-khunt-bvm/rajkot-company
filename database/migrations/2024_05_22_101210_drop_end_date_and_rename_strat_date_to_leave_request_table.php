<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropEndDateAndRenameStratDateToLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_request', function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->renameColumn('start_date', 'date');
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
            $table->date('end_date')->after('start_date');
            $table->renameColumn('date', 'start_date');
        });
    }
}
