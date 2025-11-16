<?php

use App\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->createTable('products', function ($table) {
            $table->increments('id');
            $table->string('name', 100); // 名称
            $table->string('manufacturer', 100); // 原料厂家
            $table->decimal('price', 10, 2); // 单价
            $table->string('unit', 20); // 计价单位
            $table->string('type', 50); // 产品类型
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('products');
    }
}