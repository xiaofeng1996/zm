<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnFromOrderGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('order_goods', 'service_type')) {
            Schema::table('order_goods', function($table) {
                $table->dropColumn('service_type');
                $table->dropColumn('applied_service_at');
                $table->dropColumn('audited_service_at');
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
