<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string("email");
            $table->string("password");
            $table->string("salt");
            $table->smallInteger("status",false,true);
            $table->integer("last_login_time");
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
        Schema::dropIfExists('tool_user');
    }
}
