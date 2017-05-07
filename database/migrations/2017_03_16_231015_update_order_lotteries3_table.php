<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderLotteries3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_lotteries', function (Blueprint $table) {
            $table->string('express_name')->nullable()->commit('快递公司');
            $table->string('express_nu')->nullable()->commit('快递单号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_lotteries', function (Blueprint $table) {
            $table->dropColumn('express_name', 'express_no');
        });
    }
}
