<?php

namespace App\Database;

use PDO;

class Migrator
{
    protected $connection;
    protected $migrationPath;
    protected $dbDriver;

    public function __construct($connection, $migrationPath = null)
    {
        $this->connection = $connection;
        $this->migrationPath = $migrationPath ?: __DIR__ . '/../../database/migrations';
        
        // 获取数据库驱动类型
        $this->dbDriver = $this->getDatabaseDriver();
    }

    public function run()
    {
        // 创建 migrations 表（如果不存在）
        $this->createMigrationsTable();
        
        // 获取已运行的迁移
        $ranMigrations = $this->getRanMigrations();
        
        // 获取所有迁移文件
        $files = $this->getMigrationFiles();
        
        foreach ($files as $file) {
            $filename = basename($file);
            $migrationName = str_replace('.php', '', $filename);
            
            // 如果迁移已经运行过，跳过
            if (in_array($migrationName, $ranMigrations)) {
                continue;
            }
            
            // 引入迁移文件
            require_once $file;
            
            // 获取类名（文件名转换为驼峰命名）
            $className = $this->toClassName($migrationName);
            
            // 实例化迁移类
            $migration = new $className($this->connection);
            
            // 运行迁移
            $migration->up();
            
            // 记录已运行的迁移
            $this->logMigration($migrationName);
            
            echo "Migrated: {$filename}\n";
        }
    }

    public function rollback()
    {
        // 获取最后一批运行的迁移
        $lastBatch = $this->getLastBatchNumber();
        $migrations = $this->getMigrationsByBatch($lastBatch);
        
        // 按相反顺序回滚
        foreach (array_reverse($migrations) as $migration) {
            $file = $this->getMigrationFilePath($migration['migration']);
            
            if (file_exists($file)) {
                // 引入迁移文件
                require_once $file;
                
                // 获取类名
                $className = $this->toClassName($migration['migration']);
                
                // 实例化迁移类
                $migrationInstance = new $className($this->connection);
                
                // 回滚迁移
                $migrationInstance->down();
                
                // 从日志中删除记录
                $this->deleteMigrationLog($migration['id']);
                
                echo "Rolled back: {$migration['migration']}.php\n";
            }
        }
    }

    protected function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            batch INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->connection->exec($sql);
    }

    protected function getRanMigrations()
    {
        $stmt = $this->connection->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function logMigration($migrationName)
    {
        $batch = $this->getNextBatchNumber();
        $stmt = $this->connection->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
        $stmt->execute([$migrationName, $batch]);
    }

    protected function getLastBatchNumber()
    {
        $stmt = $this->connection->query("SELECT MAX(batch) as batch FROM migrations");
        $result = $stmt->fetch();
        return $result ? (int)$result['batch'] : 0;
    }

    protected function getNextBatchNumber()
    {
        return $this->getLastBatchNumber() + 1;
    }

    protected function getMigrationsByBatch($batch)
    {
        $stmt = $this->connection->prepare("SELECT * FROM migrations WHERE batch = ? ORDER BY id DESC");
        $stmt->execute([$batch]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function deleteMigrationLog($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM migrations WHERE id = ?");
        $stmt->execute([$id]);
    }

    protected function toClassName($migrationName)
    {
        // 移除时间戳前缀，获取实际的类名部分
        $parts = explode('_', $migrationName);
        
        // 跳过前4个时间戳部分，获取类名部分
        $classNameParts = array_slice($parts, 4);
        
        // 将类名部分转换为驼峰命名
        $className = '';
        foreach ($classNameParts as $part) {
            $className .= ucfirst($part);
        }
        
        return $className;
    }

    protected function getDatabaseDriver()
    {
        // 从配置中获取数据库驱动类型
        $config = require __DIR__ . '/../../config/database.php';
        return $config['default'];
    }

    protected function getMigrationFiles()
    {
        $migrationPath = $this->migrationPath;
        
        // 如果是MySQL数据库且存在mysql子目录，则使用mysql特定的迁移文件
        if ($this->dbDriver === 'mysql' && is_dir($migrationPath . '/mysql')) {
            $migrationPath = $migrationPath . '/mysql';
        }
        
        return glob($migrationPath . '/*.php');
    }

    protected function getMigrationFilePath($migrationName)
    {
        $migrationPath = $this->migrationPath;
        
        // 如果是MySQL数据库且存在mysql子目录，则使用mysql特定的迁移文件
        if ($this->dbDriver === 'mysql' && is_dir($migrationPath . '/mysql')) {
            $migrationPath = $migrationPath . '/mysql';
        }
        
        return $migrationPath . '/' . $migrationName . '.php';
    }
}