<?php

use App\Database\Migration;

class CreateQuoteItemsTable extends Migration
{
    public function up()
    {
        $this->createTable('quote_items', function ($table) {
            $table->increments('id');
            $table->integer('quote_id'); // 报价单ID
            $table->integer('product_id'); // 产品ID
            $table->decimal('quantity', 10, 2); // 数量
            $table->decimal('unit_price', 10, 2); // 单价
            $table->decimal('discount_rate', 5, 2)->default(0); // 折扣率
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('quote_items');
    }
}