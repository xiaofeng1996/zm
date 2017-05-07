<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('上级id');
            $table->string('name', 40)->comment('菜单名称');
            $table->string('nav_index', 100)->comment('菜单唯一值');
            $table->string('is_leaf')->default(0)->comment('身份是叶子节点');
            $table->integer('sort')->default(0)->comment('显示顺序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navs');
    }
}
