<?php

namespace App\Database;

abstract class Migration
{
    abstract public function up();
    abstract public function down();

    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    protected function createTable($table, $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        
        $sql = $blueprint->toSql();
        $this->connection->exec($sql);
    }

    protected function dropTable($table)
    {
        $sql = "DROP TABLE IF EXISTS {$table}";
        $this->connection->exec($sql);
    }
}