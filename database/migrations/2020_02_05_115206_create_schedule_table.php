<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string("tool_user_id");
            $table->string("schedule_rule_id");
            $table->string("start");
            $table->string("end");
            $table->string("recursive");
            $table->string("expire_recurrsive");
            $table->string("weekday");
            $table->string("utc");
            $table->string("utc_diff");
            $table->string("start_unixtime");
            $table->string("end_unixtime");
            $table->smallInteger("status",false,true);
            $table->integer("created_time");
            $table->integer("updated_time");
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
        Schema::dropIfExists('schedule');
    }
}
