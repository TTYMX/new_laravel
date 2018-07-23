<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lh_orders', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->unsignedInteger('good_id')->nullable()->comment('商品id');
            $table->double('price', 10, 2)->nullable()->comment('购买价格');
            $table->char('order_num',32)->nullable()->comment('订单号');
            $table->tinyInteger('status')->nullable()->comment('订单状态1未付款2待发货3已发货4已收货');
            $table->string('link_name', 50)->nullable()->comment('收件人姓名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lh_orders');
    }
}
