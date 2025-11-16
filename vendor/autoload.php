<?php

spl_autoload_register(function ($class) {
    // 项目命名空间前缀
    $prefix = 'App\\';
    
    // 命名空间前缀的长度
    $len = strlen($prefix);
    
    // 如果类名不以命名空间前缀开头，则不处理
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // 获取相对类名
    $relativeClass = substr($class, $len);
    
    // 构建文件路径
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $relativeClass) . '.php';
    
    // 如果文件存在，则包含它
    if (file_exists($file)) {
        require $file;
    }
});