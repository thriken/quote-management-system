<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Migrator;

// 获取数据库连接
$config = require __DIR__ . '/config/database.php';
$dbConfig = $config['connections'][$config['default']];

// 定义数据库驱动常量
define('DB_DRIVER', $config['default']);

if ($dbConfig['driver'] === 'mysql') {
    try {
        // 创建数据库连接（不指定数据库）
        $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset={$dbConfig['charset']}";
        $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 创建数据库
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbConfig['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "数据库 '{$dbConfig['database']}' 创建成功或已存在。\n";
        
        // 重新连接到指定数据库
        $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']};charset={$dbConfig['charset']}";
        $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        die("数据库连接失败: " . $e->getMessage());
    }
} else {
    // SQLite 数据库文件会自动创建
    try {
        $dsn = "sqlite:{$dbConfig['database']}";
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "SQLite 数据库连接成功。\n";
    } catch (PDOException $e) {
        die("SQLite 数据库连接失败: " . $e->getMessage());
    }
}

// 运行迁移
try {
    $migrator = new Migrator($pdo);
    $migrator->run();
    echo "数据库迁移完成。\n";
} catch (Exception $e) {
    die("迁移过程中出现错误: " . $e->getMessage());
}

// 创建默认用户
try {
    // 检查是否已存在用户
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    
    if ($userCount == 0) {
        // 根据数据库类型使用不同的时间函数
        if ($dbConfig['driver'] === 'mysql') {
            $timeFunction = "NOW()";
        } else {
            $timeFunction = "datetime('now')";
        }
        
        // 创建默认管理员用户
        $sql = "INSERT INTO users (username, password, role, name, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?, {$timeFunction}, {$timeFunction})";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'admin',
            password_hash('admin123', PASSWORD_DEFAULT),
            '销售主管',
            '系统管理员',
            'admin@example.com'
        ]);
        
        echo "默认管理员用户创建成功。\n";
        echo "用户名: admin\n";
        echo "密码: admin123\n";
        echo "请登录后立即修改密码。\n";
    } else {
        echo "用户已存在，跳过默认用户创建。\n";
    }
} catch (Exception $e) {
    echo "创建默认用户时出现错误: " . $e->getMessage() . "\n";
}

echo "安装完成！\n";