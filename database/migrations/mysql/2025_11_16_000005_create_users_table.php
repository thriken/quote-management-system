<?php

use App\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->createTable('users', function ($table) {
            $table->increments('id');
            $table->string('username', 50); // 用户名
            $table->string('password', 255); // 密码
            $table->string('role', 20); // 角色：销售主管/客服
            $table->string('name', 100); // 姓名
            $table->string('email', 100); // 邮箱
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('users');
    }
}