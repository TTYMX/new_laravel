<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLehuiCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lehui_cards', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->unsignedInteger('good_id')->nullable()->comment('商品id');
            $table->smallInteger('num')->nullable()->comment('总数');
            $table->double('price', 10, 2)->nullable()->comment('商品价格');
            $table->string('name', 50)->nullable()->comment('商品名称');
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
        Schema::dropIfExists('lehui_cards');
    }
}
