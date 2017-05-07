<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorys', function (Blueprint $table) {
            $table->tinyInteger('lv')->default(0)->commit('类别层级, 从 0 开始');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorys', function (Blueprint $table) {
            $table->dropColumn('lv');
        });
    }
}
