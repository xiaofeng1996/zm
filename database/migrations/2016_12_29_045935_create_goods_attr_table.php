<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('attr1', 40)->nullable();
            $table->string('attr2', 40)->nullable();
            $table->string('attr3', 40)->nullable();
            $table->string('attr4', 40)->nullable();
            $table->string('attr5', 40)->nullable();
            $table->string('attr6', 40)->nullable();
            $table->string('attr7', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods_attr');
    }
}
