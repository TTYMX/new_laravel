<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lh_cates', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->timestamps();
            $table->string('name', 50)->nullable()->comment('分类名称');
            $table->unsignedInteger('pid')->nullable()->comment('所属父id');
            $table->string('path', 100)->nullable()->comment('路径');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lh_cates');
    }
}
