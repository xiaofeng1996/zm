<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->string('trade_no');
            $table->decimal('money', 10, 2)->comment('交易金额');
            $table->tinyInteger('pay_device')->nullable()->comment('支付平台, 1: 移动端, 2: pc端');
            $table->tinyInteger('pay_type')->nullable()->comment('支付方式, 1: 支付宝, 2: 银联, 3: 微信, 4: 余额');
            $table->string('fee_type', 40)->nullable()->comment('货币类型, 一般为CNY');
            $table->timestamp('created_at');
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
        Schema::drop('pays');
    }
}
