<?php

use App\Database\Migration;

class AddUniqueActiveQuotePerCustomer extends Migration
{
    public function up()
    {
        // 添加唯一索引：每个客户只能有一个生效的报价单
        $sql = "CREATE UNIQUE INDEX unique_active_quote_per_customer 
                ON quotes (customer_id, is_active) 
                WHERE is_active = 1";
        $this->connection->exec($sql);
    }

    public function down()
    {
        // 删除唯一索引
        $sql = "DROP INDEX unique_active_quote_per_customer ON quotes";
        $this->connection->exec($sql);
    }
}