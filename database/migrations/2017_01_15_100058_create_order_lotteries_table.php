<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->string('expect')->comment('期号');
            $table->string('opencode', 15)->nullable()->comment('选号, 用 "," 分隔');
            $table->timestamp('opentime')->nullable()->comment('开奖时间');
            $table->integer('opentimestamp')->comment('开奖时间戳');
            $table->tinyInteger('status')->default(0)->comment('选号状态, 0: 待开奖, 1: 中奖, 2: 未中奖');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_lotteries');
    }
}
