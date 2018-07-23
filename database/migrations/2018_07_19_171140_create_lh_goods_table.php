<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lh_goods', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('name', 50)->nullable()->comment('商品名称');
            $table->double('price', 10, 2)->nullable()->comment('商品价格');
            $table->double('old_price', 10, 2)->nullable()->comment('商品原价');
            $table->unsignedInteger('cate_id')->nullable()->comment('所属分类');
            $table->string('content', 50)->nullable()->comment('商品详情');
            $table->unsignedInteger('total')->nullable()->comment('商品数量');
            $table->tinyInteger('status')->nullable()->comment('是否上架1上架2下架');
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
        Schema::dropIfExists('lh_goods');
    }
}
