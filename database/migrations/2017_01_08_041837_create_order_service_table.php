<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_goods_id');
            $table->integer('merchant_id');

            $table->tinyInteger('service_status')->comment('售后状态, 1: 已申请, 2: 已拒绝, 3: 售后成功');
            $table->tinyInteger('service_type')->comment('售后类型, 1: 退货, 2: 换货');
            $table->timestamp('applied_service_at')->nullable();
            $table->decimal('applied_fee', 10, 2)->default(0)->comment('申请退款费用');
            $table->tinyInteger('applied_goods_num')->defalut(1)->comment('申请售后品您数量');
            $table->string('applied_reason', 255)->comment('申请售后原因');

            $table->timestamp('audited_service_at')->nullable();
            $table->decimal('real_refunded', 10, 2)->default(0)->comment('实际退款');
            $table->string('deal_desc')->nullable()->comment('请求处理描述');

            $table->integer('admin_id')->default(0)->comment('处理该请求的管理员id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_services');
    }
}
