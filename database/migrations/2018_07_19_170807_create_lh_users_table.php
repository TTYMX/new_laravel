<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lh_users', function (Blueprint $table) {
            $table->increments('id')->comment('自增id');
            $table->string('usename', 50)->nullable()->comment('用户名');
            $table->char('password', 128)->nullable()->comment('用户密码');
            $table->char('email', 30)->nullable()->comment('邮箱');
            $table->char('phone', 11)->nullable()->comment('手机号');
            $table->char('token', 100)->nullable()->comment('token值');
            $table->char('pic', 100)->nullable()->comment('图片地址');
            $table->smallInteger('auth')->nullable()->comment('后台权限0没有1有');
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
        Schema::dropIfExists('lh_users');
    }
}
