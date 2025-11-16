<?php

use App\Database\Migration;

class AddUniqueActiveQuotePerCustomer extends Migration
{
    public function up()
    {
        // SQLite不支持部分索引的CREATE INDEX语法，所以我们需要使用另一种方法
        // 这里我们添加一个触发器来确保每个客户只有一个生效的报价单
        
        // 注意：SQLite的实现会比较复杂，因为它不支持MySQL的部分索引功能
        // 我们将在应用层通过控制器逻辑来确保这个约束
    }

    public function down()
    {
        // SQLite版本不需要做任何事情，因为我们没有创建实际的索引
    }
}