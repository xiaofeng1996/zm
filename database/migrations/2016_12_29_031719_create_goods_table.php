<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->comment('商家id');
            $table->integer('category_id')->comment('商品类别id');
            $table->string('name', 255)->comment('商品名称');
            $table->string('image', 255)->comment('商品封面图片');
            $table->decimal('price', 10, 2)->comment('商品价格');
            $table->decimal('old_price', 10, 2)->comment('商品原价');
            // $table->decimal('fare', 10, 2)->default(0)->comment('运费');
            $table->tinyInteger('support_return')->default(1)->comment('是否支持退换货, 0: 不支持, 1: 支持');
            $table->tinyInteger('is_lucky')->default(0)->comment('是否是幸运区商品, 0, 否, 1: 是');
            $table->tinyInteger('recommend')->default(0)->comment('是否推荐商品, 一般推荐商品放在首页, 0: 不推荐, 1: 推荐');
            $table->tinyInteger('lucky_num')->default(1)->comment('购买商品所获抽奖次数');
            $table->tinyInteger('lucky_rate')->default(1)->comment('中奖概率');
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
        Schema::drop('goods');
    }
}
