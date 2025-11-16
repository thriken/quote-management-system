<?php

use App\Database\Migration;

class CreateQuotesTable extends Migration
{
    public function up()
    {
        $this->createTable('quotes', function ($table) {
            $table->increments('id');
            $table->integer('customer_id'); // 客户ID
            $table->string('category', 20); // 报价单分类：我司/他司/预期/客定
            $table->string('version', 20); // 版本号
            $table->boolean('is_active')->default(0); // 是否生效
            $table->decimal('discount_rate', 5, 2)->default(0); // 折扣率
            $table->decimal('rebate_rate', 5, 2)->default(0); // 返点率
            $table->date('effective_date')->nullable(); // 生效日期
            $table->date('expiry_date')->nullable(); // 失效日期
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('quotes');
    }
}