<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pays', 'keytype')) {
            Schema::table('pays', function (Blueprint $table) {
                $table->integer('keytype')->comment('支付记录业务类型, 1: 订单');
                $table->integer('keyid')->comment('支付记录业务id, 1: 订单');
                $table->dropColumn('order_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
