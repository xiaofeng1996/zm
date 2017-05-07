<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('orders', 'buy_type')) {
            Schema::table('orders', function($table) {
                $table->tinyInteger('buy_type')->default(1)->comment('购买方式, 1: 会员区直接购买, 2: 幸运区直接购买, 3: 购物车购买');
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
