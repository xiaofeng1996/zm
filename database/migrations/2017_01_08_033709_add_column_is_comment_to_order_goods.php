<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsCommentToOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('order_goods', 'is_comment')) {
            Schema::table('order_goods', function(Blueprint $table) {
                $table->tinyInteger('is_comment')->default(0)->comment('是否已评论, 0: 否, 1: 是');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
