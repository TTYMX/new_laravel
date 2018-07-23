<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lh_pics', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->timestamps();
            $table->unsignedInteger('good_id')->nullable()->comment('商品id');
            $table->string('path', 100)->nullable()->comment('图片路径');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lh_pics');
    }
}
