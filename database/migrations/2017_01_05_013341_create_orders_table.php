<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('merchant_id');

            $table->string('name', 100)->comment('收货人姓名');
            $table->string('mobile', 20)->comment('收货人电话');
            $table->string('address', 255)->comment('收货人地址');
            
            $table->string('out_trade_no')->nullable()->comment('订单号');
            $table->decimal('total_money', 10, 2)->comment('订单总价格, 单位是元');
            $table->decimal('fare', 10, 2)->default(0)->comment('运费, 单位是元');
            $table->integer('total_goods_num')->comment('订单中包含的商品总数量');

            $table->tinyInteger('status')->default(1)->comment('订单状态, 1: 待支付, 2: 待发货, 3: 待收货, 4: 待评价, 5:已评价');
            $table->timestamp('created_at');
            $table->timestamp('paid_at')->nullable()->comment('支付时间');
            $table->timestamp('delivered_at')->nullable()->comment('发货时间');
            $table->timestamp('receipted_at')->nullable()->comment('收货时间');
            $table->timestamp('commented_at')->nullable()->comment('评论时间');

            // $table->tinyInteger('service_status')->default(0)->comment('售后状态, 0: 未申请售后, 1: 已申请, 2: 审核失败, 3: 审核通过');
            // $table->tinyInteger('service_type')->default(0)->comment('申请售后类型, 0: 未申请售后, 1: 申请退货, 2: 申请换货');
            // $table->timestamp('applied_service_at')->comment('申请售后时间');
            // $table->timestamp('audited_service_at')->comment('售后审核时间');

            $table->string('express_name', 100)->nullable()->comment('快递公司名称');
            $table->string('express_nu')->nullable()->comment('快递单号');

            // $table->tinyInteger('pay_device')->nullable()->comment('支付平台, 1: 移动端, 2: pc端');
            // $table->tinyInteger('pay_type')->nullable()->comment('支付方式, 1: 支付宝, 2: 银联, 3: 微信');
            // $table->string('fee_type', 40)->nullable()->comment('货币类型, 一般为CNY');

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
        Schema::drop('orders');
    }
}
