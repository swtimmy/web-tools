<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCrawlerPost20191225 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawler_post', function (Blueprint $table) {
            $table->integer("crawler_page_id");
            $table->string("title");
            $table->string("description")->nullable();
            $table->string("image")->nullable();
            $table->string("url");
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
        Schema::table('crawler_post', function (Blueprint $table) {
            $table->dropColumn(['crawler_page_id','title','description','url','image','status','created_time','updated_time']);
        });
    }
}
