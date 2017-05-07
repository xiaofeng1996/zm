<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 40)->nullable();
            $table->string('mobile', 15);
            $table->string('avatar', 255)->nullable()->default('/images/face_small.jpg');
            $table->string('password', 100);
            $table->string('pay_password', 100)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('openid', 100)->nullable();
            $table->string('unionid', 100)->nullable();
            $table->string('weiboid', 100)->nullable();
            $table->string('idstr', 100)->nullable();
            $table->string('qq_openid', 100)->nullable();
            $table->tinyInteger('device')->default(0);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
