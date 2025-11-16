<?php

namespace App;

class View
{
    protected $layout;

    public function __construct($layout = null)
    {
        $this->layout = $layout ?: 'layout';
    }

    public function render($view, $data = [])
    {
        // 提取数据变量
        extract($data);
        
        // 开始输出缓冲
        ob_start();
        
        // 包含视图文件
        $viewPath = __DIR__ . "/../resources/views/{$view}.php";
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: {$view}";
        }
        
        // 获取视图内容
        $content = ob_get_clean();
        
        // 如果有布局文件，包含布局文件
        $layoutPath = __DIR__ . "/../resources/views/{$this->layout}.php";
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo $content;
        }
    }

    public function layout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
}