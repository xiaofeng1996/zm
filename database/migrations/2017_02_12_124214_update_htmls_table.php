<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHtmlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('htmls', function (Blueprint $table) {
            $table->string('htmlable_type')->comment('关联模型');
            $table->integer('htmlable_id')->comment('关联模型主键id');
            $table->timestamps();
            $table->dropColumn('type');
            $table->text('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('htmls', function (Blueprint $table) {
            $table->dropColumn('htmlable_type', 'htmlable_id', 'created_at', 'updated_at');
            $table->tinyInteger('type');
        });
    }
}
