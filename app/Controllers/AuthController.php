<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['name']);
        session_destroy();
        
        // 重定向到登录页面 - 添加额外的HTTP头确保兼容性
        header("Location: /login");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        exit;
    }
    
    public function login()
    {
        // 检查用户是否已经登录
        session_start();
        if (isset($_SESSION['user_id'])) {
            // 如果已登录，重定向到首页
            header("Location: /");
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Expires: 0");
            exit;
        }
        
        return $this->render('auth/login');
    }

    public function authenticate()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        // 查找用户
        $users = $this->user->where('username', $username);
        $user = !empty($users) ? $users[0] : null;

        // 验证用户和密码
        if ($user && password_verify($password, $user['password'])) {
            // 设置会话
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // 重定向到首页 - 添加额外的HTTP头确保兼容性
            header("Location: /");
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Expires: 0");
            exit;
        } else {
            // 登录失败，返回登录页面并显示错误
            return $this->render('auth/login', [
                'error' => '用户名或密码错误'
            ]);
        }
    }
}