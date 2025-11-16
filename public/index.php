<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\CustomerController;
use App\Controllers\QuoteController;
use App\Controllers\ProductController;
use App\Controllers\UserController;
use App\Controllers\QuoteItemController;
use App\Controllers\AuthController;
use App\Controllers\QuoteComparisonController;
use App\Controllers\InstallController;

// 启动会话
session_start();

// 创建路由器实例
$router = new Router();

// 定义安装路由（无需登录）
$router->get('/install', [new InstallController(), 'show']);
$router->post('/install', [new InstallController(), 'install']);

// 定义无需登录的路由
$router->get('/login', [new AuthController(), 'login']);
$router->post('/login', [new AuthController(), 'authenticate']);
$router->post('/logout', [new AuthController(), 'logout']);

// 检查用户是否已登录
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// 检查用户角色
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

// 定义需要登录的路由
function defineProtectedRoutes($router) {
    // 首页路由
    $router->get('/', function() {
        $content = "<h1 class='text-3xl font-bold text-center mb-8'>报价单管理系统</h1>";
        $content .= "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6'>";
        $content .= "<div class='bg-white rounded-lg shadow-md p-6'>";
        $content .= "<h2 class='text-xl font-bold mb-4'>客户管理</h2>";
        $content .= "<p class='mb-4'>管理客户信息和资料</p>";
        $content .= "<a href='/customers' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block'>进入</a>";
        $content .= "</div>";
        $content .= "<div class='bg-white rounded-lg shadow-md p-6'>";
        $content .= "<h2 class='text-xl font-bold mb-4'>产品管理</h2>";
        $content .= "<p class='mb-4'>管理产品信息和价格</p>";
        $content .= "<a href='/products' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block'>进入</a>";
        $content .= "</div>";
        $content .= "<div class='bg-white rounded-lg shadow-md p-6'>";
        $content .= "<h2 class='text-xl font-bold mb-4'>报价单管理</h2>";
        $content .= "<p class='mb-4'>创建和管理报价单</p>";
        $content .= "<a href='/quotes' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block'>进入</a>";
        $content .= "</div>";
        $content .= "<div class='bg-white rounded-lg shadow-md p-6'>";
        $content .= "<h2 class='text-xl font-bold mb-4'>用户管理</h2>";
        $content .= "<p class='mb-4'>管理系统用户和权限</p>";
        $content .= "<a href='/users' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block'>进入</a>";
        $content .= "</div>";
        $content .= "</div>";
        
        // 显示当前用户信息
        $content .= "<div class='mt-8 text-center text-gray-600'>";
        $content .= "<p>欢迎您，" . htmlspecialchars($_SESSION['username'] ?? '访客') . " (" . htmlspecialchars($_SESSION['role'] ?? '未登录') . ") ";
        $content .= "<a href='/logout' class='text-blue-600 hover:text-blue-800'>退出登录</a></p>";
        $content .= "</div>";
        
        include __DIR__ . '/../resources/views/layout.php';
    });

    // 客户路由
    $router->get('/customers', [new CustomerController(), 'index']);
    $router->get('/customers/create', [new CustomerController(), 'create']);
    $router->post('/customers', [new CustomerController(), 'store']);
    $router->get('/customers/edit/{id}', [new CustomerController(), 'edit']);
    $router->post('/customers/{id}', [new CustomerController(), 'update']);
    $router->post('/customers/delete/{id}', [new CustomerController(), 'destroy']);

    // 报价单路由
    $router->get('/quotes', [new QuoteController(), 'index']);
    $router->get('/quotes/create', [new QuoteController(), 'create']);
    $router->post('/quotes', [new QuoteController(), 'store']);
    $router->get('/quotes/edit/{id}', [new QuoteController(), 'edit']);
    $router->post('/quotes/{id}', [new QuoteController(), 'update']);
    $router->post('/quotes/delete/{id}', [new QuoteController(), 'destroy']);

    // 报价单项目路由
    $router->get('/quotes/{quoteId}/items', [new QuoteItemController(), 'index']);
    $router->get('/quotes/{quoteId}/items/create', [new QuoteItemController(), 'create']);
    $router->post('/quotes/{quoteId}/items', [new QuoteItemController(), 'store']);
    $router->get('/quotes/{quoteId}/items/edit/{itemId}', [new QuoteItemController(), 'edit']);
    $router->post('/quotes/{quoteId}/items/{itemId}', [new QuoteItemController(), 'update']);
    $router->post('/quotes/{quoteId}/items/delete/{itemId}', [new QuoteItemController(), 'destroy']);

    // 报价单对比路由
    $router->get('/quotes/comparison', [new QuoteComparisonController(), 'index']);
    $router->post('/quotes/comparison', [new QuoteComparisonController(), 'compare']);

    // 产品路由
    $router->get('/products', [new ProductController(), 'index']);
    $router->get('/products/create', [new ProductController(), 'create']);
    $router->post('/products', [new ProductController(), 'store']);
    $router->get('/products/edit/{id}', [new ProductController(), 'edit']);
    $router->post('/products/{id}', [new ProductController(), 'update']);
    $router->post('/products/delete/{id}', [new ProductController(), 'destroy']);

    // 用户路由 (仅销售主管可访问)
    $router->get('/users', function() {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->index();
    });
    
    $router->get('/users/create', function() {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->create();
    });
    
    $router->post('/users', function() {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->store();
    });
    
    $router->get('/users/edit/{id}', function($id) {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->edit($id);
    });
    
    $router->post('/users/{id}', function($id) {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->update($id);
    });
    
    $router->post('/users/delete/{id}', function($id) {
        if (!hasRole('销售主管')) {
            http_response_code(403);
            $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>访问被拒绝</h1>";
            $content .= "<div class='text-center'>";
            $content .= "<p class='mb-6'>您没有权限访问此页面</p>";
            $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
            $content .= "</div>";
            include __DIR__ . '/../resources/views/layout.php';
            return;
        }
        $controller = new UserController();
        return $controller->destroy($id);
    });
}

if (isAuthenticated()) {
    defineProtectedRoutes($router);
} else {
    // 如果用户未登录，将所有受保护的路由重定向到登录页面
    $router->get('/', function() {
        header('Location: /login');
        exit;
    });
    
    // 重新定义受保护的路由，重定向到登录页面
    defineProtectedRoutes($router);
}

// 解析当前请求
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$route = $router->resolve($uri, $method);

if ($route) {
    if (is_callable($route)) {
        // 直接调用匿名函数
        echo $route();
    } elseif (is_array($route) && isset($route['callback'])) {
        // 带参数的路由
        $callback = $route['callback'];
        $params = $route['params'];
        if (is_callable($callback)) {
            echo call_user_func_array($callback, $params);
        } else {
            // 控制器方法
            $controller = $callback[0];
            $method = $callback[1];
            echo call_user_func_array([$controller, $method], $params);
        }
    } elseif (is_array($route)) {
        // 控制器方法路由
        $controller = $route[0];
        $method = $route[1];
        echo call_user_func([$controller, $method]);
    }
} else {
    // 404 页面
    http_response_code(404);
    $content = "<h1 class='text-3xl font-bold text-red-600 text-center mb-8'>404 页面未找到</h1>";
    $content .= "<div class='text-center'>";
    $content .= "<p class='mb-6'>您访问的页面不存在</p>";
    $content .= "<a href='/' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>返回首页</a>";
    $content .= "</div>";
    include __DIR__ . '/../resources/views/layout.php';
}