<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('keytype')->comment('消息类型, 1: 普通文本通知, 2: 商品相关的通知, 3: 订单相关的通知, 4: 售后相关通知, 5: 活动通知');
            $table->integer('keyid')->comment('消息对应主键id, keytype=1 时, keyid=0, keytype=2 时, keyid=[商品id], keytype=3 时, keyid=[订单id], keytype=4 时, keyid=[售后id], keytype=5时, keyid=0');
            $table->string('content')->comment('消息内容');
            $table->tinyInteger('is_read')->comment('是否已读, 0: 未读, 1: 已读');
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
        Schema::drop('notices');
    }
}
