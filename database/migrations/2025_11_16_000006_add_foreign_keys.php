<?php

use App\Database\Migration;

class AddForeignKeys extends Migration
{
    public function up()
    {
        // SQLite不支持在ALTER TABLE中添加外键约束
        // 外键关系将在应用层面处理
        echo "Foreign key constraints are not added in SQLite. They will be handled at the application level.\n";
    }

    public function down()
    {
        // SQLite中没有添加外键约束，所以不需要删除
        echo "No foreign key constraints to drop in SQLite.\n";
    }
}