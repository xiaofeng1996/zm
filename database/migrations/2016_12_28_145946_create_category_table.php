<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('name', 100)->comment('分类名称');
            $table->string('image', 255)->nullable()->comment('图片');
            $table->tinyInteger('recommend')->default(0)->comment('是否是推荐类别, 0: 否, 1:　是');
            $table->integer('sort')->default(0)->comment('显示顺序');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categorys');
    }
}
