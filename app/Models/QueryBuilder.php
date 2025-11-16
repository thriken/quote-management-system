<?php

namespace App\Models;

use PDO;

class QueryBuilder
{
    protected $connection;
    protected $table;
    protected $conditions = [];
    protected $bindings = [];
    protected $orderBy = [];
    protected $limit;
    protected $offset;

    public function __construct($connection, $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function where($column, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->conditions[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this;
    }

    public function whereIn($column, array $values)
    {
        $placeholders = str_repeat('?,', count($values) - 1) . '?';
        $this->conditions[] = "{$column} IN ({$placeholders})";
        $this->bindings = array_merge($this->bindings, $values);

        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy[] = "{$column} {$direction}";

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function get()
    {
        $sql = $this->buildSelectQuery();
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->fetchAll();
    }

    public function first()
    {
        $result = $this->limit(1)->get();

        return isset($result[0]) ? $result[0] : null;
    }

    public function count()
    {
        $sql = $this->buildCountQuery();
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($this->bindings);

        return (int) $stmt->fetchColumn();
    }

    protected function buildSelectQuery()
    {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }

        return $sql;
    }

    protected function buildCountQuery()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }

        return $sql;
    }
}