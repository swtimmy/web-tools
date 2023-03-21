<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCrawlerPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawler_posts', function (Blueprint $table) {
            //
		$table->string('title')->after('url');
		$table->longText('content')->after('title');
		$table->integer('create_time')->after('content');
		$table->integer('update_time')->after('create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawler_posts', function (Blueprint $table) {
            //
		$table->dropColumn(['title','content','create_time','update_time']);
        });
    }
}
