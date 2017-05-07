<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expect', 100)->comment('开奖期数');
            $table->string('opencode')->comment('开奖号码, 用 "," 分隔');
            $table->timestamp('opentime')->comment('开奖时间');
            $table->integer('opentimestamp')->comment('开奖时间戳');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lotteries');
    }
}
