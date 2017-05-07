<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('keytype')->comment('banner 跳转类型, 1: 跳转到商品详情, 2: 跳转到网页链接');
            $table->integer('keyid')->default(0)->comment('keytype=1 时, 保存商品id, keytype=2 时, 为0');
            $table->integer('sort')->default(0)->comment('显示顺序');
            $table->string('image')->comment('展示图片');
            $table->string('link')->nullable()->comment('如果是网页跳转banner, 保存跳转链接');
            $table->tinyInteger('active')->defalut(1)->comment('是否显示');
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
        Schema::drop('banners');
    }
}
