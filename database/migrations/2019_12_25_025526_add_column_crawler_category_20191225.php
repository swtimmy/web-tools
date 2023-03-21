<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCrawlerCategory20191225 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawler_category', function (Blueprint $table) {
            $table->string("name");
            $table->smallInteger("status")->default(0);
            $table->integer("created_time");
            $table->integer("updated_time");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawler_category', function (Blueprint $table) {
            $table->dropColumn(['name','status','created_time','updated_time']);
        });
    }
}
