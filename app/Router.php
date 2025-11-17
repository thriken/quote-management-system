<?php

namespace App;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function get($uri, $callback)
    {
        $this->routes['GET'][$uri] = $callback;
        return $this;
    }

    public function post($uri, $callback)
    {
        $this->routes['POST'][$uri] = $callback;
        return $this;
    }

    public function put($uri, $callback)
    {
        $this->routes['PUT'][$uri] = $callback;
        return $this;
    }

    public function delete($uri, $callback)
    {
        $this->routes['DELETE'][$uri] = $callback;
        return $this;
    }

    public function resolve($uri, $method)
    {
        // 移除查询字符串
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        // 处理尾部斜杠
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        if (isset($this->routes[$method][$uri])) {
            return $this->routes[$method][$uri];
        }

        // 处理带参数的路由
        foreach ($this->routes[$method] as $route => $callback) {
            $routePattern = $this->convertToRegex($route);
            if (preg_match($routePattern, $uri, $matches)) {
                array_shift($matches); // 移除完整匹配
                return ['callback' => $callback, 'params' => $matches];
            }
        }

        return null;
    }

    protected function convertToRegex($route)
    {
        // 将 {paramName} 转换为正则表达式
        $route = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        return '#^' . $route . '$#';
    }
}