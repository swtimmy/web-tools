<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCrawlerPostTag20191225 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawler_post_tag', function (Blueprint $table) {
            $table->integer("crawler_post_id");
            $table->integer("crawler_tag_id");
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
        Schema::table('crawler_post_tag', function (Blueprint $table) {
            $table->dropColumn(['crawler_post_id','crawler_tag_id','status','created_time','updated_time']);
        });
    }
}
