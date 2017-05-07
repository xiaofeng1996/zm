<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('image', 255);
            $table->string('mobile', 20);
            $table->string('province', 100)->nullable()->comment('商家省份');
            $table->string('city', 100)->nullable()->comment('商家所在城市');
            $table->string('district', 100)->nullable()->comment('商家所在地区');
            $table->string('address', 100)->nullable()->comment('商家详细地址');
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
        //
        Schema::drop('merchants');
    }
}
