<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function($table) {
            $table->tinyInteger('award_status')->default(0)->comment('投注状态, 只针对幸运区商品订单, 0: 未开奖, 1: 中奖, 2: 未中奖');
            $table->string('lottery_expect')->nullable()->comment('该订单投注的时时彩期号');
            $table->string('opencode', 20)->nullable()->comment('开奖号码');
        });
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
