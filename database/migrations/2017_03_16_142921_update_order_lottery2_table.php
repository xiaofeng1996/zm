<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderLottery2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_lotteries', function (Blueprint $table) {
            $table->tinyInteger('operate_status')->default(0)->commit('奖品处理状态, 0: 未处理, 1: 已发货, 2: 已收货');
            $table->timestamp('operated_at')->nullable()->commit('奖品处理时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_lotteries', function (Blueprint $table) {
            $table->dropColumn('operate_status', 'operated_at');
        });
    }
}
