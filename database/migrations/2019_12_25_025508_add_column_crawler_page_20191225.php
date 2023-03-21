<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCrawlerPage20191225 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawler_page', function (Blueprint $table) {
            $table->integer("crawler_website_id");
            $table->string("name");
            $table->string("prefix")->nullable();
            $table->string("url");
            $table->string("crawler_condition");
            $table->string("ignore_string");
            $table->string("keep_string");
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
        Schema::table('crawler_page', function (Blueprint $table) {
            $table->dropColumn(['crawler_website_id','name','prefix','url','crawler_condition','ignore_string','keep_string','status','created_time','updated_time']);
        });
    }
}
