<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('attr_id');
            $table->string('name', 255)->comment('商品名称');
            $table->string('image', 255)->comment('商品图片');
            $table->string('attr', 255)->comment('商品规格');
            $table->integer('price')->comment('商品价格，以分为单位');
            $table->tinyInteger('goods_num')->comment('商品数量');

            $table->tinyInteger('service_status')->default(0)->comment('售后状态, 0: 未申请售后, 1: 已申请, 2: 审核失败, 3: 审核通过');
            $table->tinyInteger('service_type')->default(0)->comment('申请售后类型, 0: 未申请售后, 1: 申请退货, 2: 申请换货');
            $table->timestamp('applied_service_at')->nullable()->comment('申请售后时间');
            $table->timestamp('audited_service_at')->nullable()->comment('售后审核时间');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_goods');
    }
}
