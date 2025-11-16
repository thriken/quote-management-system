<?php

use App\Database\Migration;

class AddForeignKeys extends Migration
{
    public function up()
    {
        // 为 quote_items 表添加外键约束
        $sql = "ALTER TABLE quote_items 
                ADD CONSTRAINT fk_quote_items_quote_id 
                FOREIGN KEY (quote_id) REFERENCES quotes(id) 
                ON DELETE CASCADE";
        $this->connection->exec($sql);
        
        $sql = "ALTER TABLE quote_items 
                ADD CONSTRAINT fk_quote_items_product_id 
                FOREIGN KEY (product_id) REFERENCES products(id) 
                ON DELETE CASCADE";
        $this->connection->exec($sql);
        
        // 为 quotes 表添加外键约束
        $sql = "ALTER TABLE quotes 
                ADD CONSTRAINT fk_quotes_customer_id 
                FOREIGN KEY (customer_id) REFERENCES customers(id) 
                ON DELETE CASCADE";
        $this->connection->exec($sql);
    }

    public function down()
    {
        // 删除外键约束
        $sql = "ALTER TABLE quote_items DROP FOREIGN KEY fk_quote_items_quote_id";
        $this->connection->exec($sql);
        
        $sql = "ALTER TABLE quote_items DROP FOREIGN KEY fk_quote_items_product_id";
        $this->connection->exec($sql);
        
        $sql = "ALTER TABLE quotes DROP FOREIGN KEY fk_quotes_customer_id";
        $this->connection->exec($sql);
    }
}