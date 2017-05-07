<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttrCategoryVals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_attr_category_vals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_attr_category_id')->comment('所属属性id');
            $table->string('val', 50)->comment('属性值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods_attr_category_vals');
    }
}
