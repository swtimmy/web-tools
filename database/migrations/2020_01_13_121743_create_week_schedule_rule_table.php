<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekScheduleRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_schedule_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->string("tool_user_id");
            $table->string("name");
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
        Schema::dropIfExists('week_schedule_rule');
    }
}
