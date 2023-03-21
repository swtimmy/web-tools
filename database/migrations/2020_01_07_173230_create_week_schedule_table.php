<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("tool_user_id");
            $table->string("title");
            $table->smallInteger("status",false,true);
            $table->integer("start_time");
            $table->integer("end_time");
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
        Schema::dropIfExists('week_schedule');
    }
}
