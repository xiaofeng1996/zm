<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'account_balance')) {
            Schema::table('users', function($table) {
                $table->decimal('account_balance', 10, 2)->default(0)->comment('现金余额, 可提现');       
            });
        }
        if (!Schema::hasColumn('users', 'shop_balance')) {
            Schema::table('users', function($table) {
                $table->decimal('shop_balance', 10, 2)->default(0)->comment('购物金余额, 不可体现');       
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
