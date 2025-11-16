<?php

namespace App\Database;

class Blueprint
{
    protected $table;
    protected $columns = [];
    protected $primaryKeys = [];
    protected $foreignKeys = [];
    protected $currentColumn = null;
    protected $isMySQL = false;

    public function __construct($table)
    {
        $this->table = $table;
        // 检查是否使用MySQL
        $this->isMySQL = $this->isUsingMySQL();
    }

    public function increments($name)
    {
        if ($this->isMySQL) {
            $this->columns[] = "{$name} INT UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        } else {
            $this->columns[] = "{$name} INTEGER PRIMARY KEY AUTOINCREMENT";
        }
        return $this;
    }

    public function string($name, $length = 255)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} VARCHAR({$length})";
        } else {
            $this->columns[] = "{$name} VARCHAR({$length})";
        }
        return $this;
    }

    public function text($name)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} TEXT";
        } else {
            $this->columns[] = "{$name} TEXT";
        }
        return $this;
    }

    public function integer($name)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} INT";
        } else {
            $this->columns[] = "{$name} INTEGER";
        }
        return $this;
    }

    public function decimal($name, $precision = 8, $scale = 2)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} DECIMAL({$precision}, {$scale})";
        } else {
            $this->columns[] = "{$name} DECIMAL({$precision}, {$scale})";
        }
        return $this;
    }

    public function boolean($name)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} TINYINT(1)";
        } else {
            $this->columns[] = "{$name} BOOLEAN";
        }
        return $this;
    }

    public function date($name)
    {
        $this->currentColumn = count($this->columns);
        if ($this->isMySQL) {
            $this->columns[] = "{$name} DATE";
        } else {
            $this->columns[] = "{$name} DATE";
        }
        return $this;
    }

    public function timestamps()
    {
        if ($this->isMySQL) {
            $this->columns[] = "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            $this->columns[] = "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        } else {
            $this->columns[] = "created_at DATETIME DEFAULT CURRENT_TIMESTAMP";
            $this->columns[] = "updated_at DATETIME DEFAULT CURRENT_TIMESTAMP";
        }
        return $this;
    }

    public function default($value)
    {
        if ($this->currentColumn !== null && isset($this->columns[$this->currentColumn])) {
            $columnDefinition = $this->columns[$this->currentColumn];
            if (is_numeric($value)) {
                $columnDefinition .= " DEFAULT {$value}";
            } else {
                $columnDefinition .= " DEFAULT '{$value}'";
            }
            $this->columns[$this->currentColumn] = $columnDefinition;
        }
        return $this;
    }

    public function nullable()
    {
        if ($this->currentColumn !== null && isset($this->columns[$this->currentColumn])) {
            // MySQL中需要显式指定NULL，SQLite中默认就是nullable
            if ($this->isMySQL) {
                $columnDefinition = $this->columns[$this->currentColumn];
                // 移除可能已存在的NOT NULL
                $columnDefinition = str_replace(' NOT NULL', '', $columnDefinition);
                $this->columns[$this->currentColumn] = $columnDefinition;
            }
        }
        return $this;
    }

    public function primary($columns)
    {
        if (is_string($columns)) {
            $columns = [$columns];
        }
        $this->primaryKeys = array_merge($this->primaryKeys, $columns);
        return $this;
    }

    public function foreign($column)
    {
        // Foreign key implementation would go here
        return $this;
    }

    public function references($column)
    {
        // References implementation would go here
        return $this;
    }

    public function on($table)
    {
        // On implementation would go here
        return $this;
    }

    public function toSql()
    {
        $sql = "CREATE TABLE {$this->table} (";
        
        $columnDefinitions = $this->columns;
        
        $sql .= implode(', ', $columnDefinitions);
        $sql .= ")";
        
        // MySQL特定选项
        if ($this->isMySQL) {
            $sql .= " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        }
        
        return $sql;
    }

    protected function isUsingMySQL()
    {
        // 从配置中获取数据库驱动类型
        $config = require __DIR__ . '/../../config/database.php';
        return $config['default'] === 'mysql';
    }
}