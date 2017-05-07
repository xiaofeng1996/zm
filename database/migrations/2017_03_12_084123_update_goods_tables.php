<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('goods', 'rich_content_link')) {
            Schema::table('goods', function (Blueprint $table) {
                $table->string('rich_content_link')->nullable()->default('richtext')->commit('图文详情地址');
            });
        }

        Schema::dropIfExists('goods_rich_text');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('rich_content_link');
        });
    }
}
