<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('apply_type')->comment('申请提现方式, 1: 银行卡提现, 2: 支付宝提现');
            $table->string('ali_account')->nullable()->comment('支付宝账号');
            $table->string('bank_name')->nullable()->comment('银行名称');
            $table->string('bank_card_no')->nullable()->comment('银行卡号');
            $table->string('bank_user_name')->nullable()->comment('银行卡户主');
            $table->decimal('money', 10, 2)->comment('申请提现金额');
            $table->tinyInteger('status')->default(0)->comment('提现状态, 1: 申请中, 2: 完成提现, 3: 被拒绝');
            $table->string('desc')->nullable()->comment('审核说明');
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
        Schema::drop('cashes');
    }
}
