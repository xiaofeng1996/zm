<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->tinyInteger('type')->comment('账户类型, 1: 现金余额, 2: 购物金');
            $table->tinyInteger('chg_type')->comment('账户变动类型, 1: 增加, 2: 减少');
            $table->decimal('money', 10, 2)->comment('变动金钱数');
            $table->string('money_str')->comment('格式化的金钱变动');
            $table->string('desc')->comment('变动说明');
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
        Schema::drop('balance_records');
    }
}
