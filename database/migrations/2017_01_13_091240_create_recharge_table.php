<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('invite_mobile', 20)->nullable();
            $table->integer('invite_user_id');
            $table->decimal('total_money', 10, 2);
            $table->tinyInteger('status')->default(0)->comment('充值状态, 0: 未支付, 1: 已支付');
            $table->string('out_trade_no')->nullable()->comment('订单号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recharges');
    }
}
