<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('working_times')) {
            Schema::dropIfExists('working_times');
        }

        Schema::create('working_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date_checkin'); // Chỉ lưu ngày
            $table->timestamp('time_checkin')->nullable(); // Lưu thời gian check-in
            $table->timestamp('time_checkout')->nullable(); // Lưu thời gian check-out
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('working_times');
    }
}
