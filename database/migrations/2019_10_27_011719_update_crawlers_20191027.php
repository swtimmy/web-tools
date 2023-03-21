<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCrawlers20191027 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawlers', function (Blueprint $table) {
            $table->string("prefix",255)->after("name")->nullable();
            $table->string("url",255)->after("prefix")->unique();
            $table->smallInteger("status",false,true)->after("url")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawlers', function (Blueprint $table) {
            $table->dropColumn(['prefix','url','status']);
        });
    }
}
