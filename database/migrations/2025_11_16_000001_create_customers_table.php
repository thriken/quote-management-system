<?php

use App\Database\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        $this->createTable('customers', function ($table) {
            $table->increments('id');
            $table->string('code', 10); // 速记码 [大写字母]
            $table->string('short_name', 100); // 客户简称
            $table->string('full_name', 200); // 客户全称
            $table->text('address'); // 客户地址
            $table->string('phone', 20); // 客户电话
            $table->string('company_name', 200); // 单位名称
            $table->string('credit_code', 50); // 统一社会信用代码
            $table->string('bank', 100); // 开户银行
            $table->string('account_number', 100); // 账号+行号
            $table->string('level', 50); // 客户级别
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('customers');
    }
}