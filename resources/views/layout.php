<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>报价单管理系统</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- 导航栏 -->
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="text-xl font-bold">报价单管理系统</div>
                    <div class="flex space-x-4">
                        <?php 
                        // 包含常量文件
                        require_once __DIR__ . '/../../config/const.php';
                        
                        if (isset($_SESSION['user_id'])): ?>
                            <a href="/" class="hover:bg-blue-700 px-3 py-2 rounded">首页</a>
                            <a href="/customers" class="hover:bg-blue-700 px-3 py-2 rounded">客户管理</a>
                            <a href="/products" class="hover:bg-blue-700 px-3 py-2 rounded">产品管理</a>
                            <a href="/quotes" class="hover:bg-blue-700 px-3 py-2 rounded">报价单管理</a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === '销售主管'): ?>
                                <a href="/users" class="hover:bg-blue-700 px-3 py-2 rounded">用户管理</a>
                            <?php endif; ?>
                            <a href="/logout" class="hover:bg-blue-700 px-3 py-2 rounded">退出 (<?= htmlspecialchars($_SESSION['name'] ?? '') . ':' . htmlspecialchars($_SESSION['role'] ?? '') ?>)</a>
                        <?php else: ?>
                            <a href="/login" class="hover:bg-blue-700 px-3 py-2 rounded">登录</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- 主要内容 -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <?= $content ?? '' ?>
        </main>

        <!-- 页脚 -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; 2025 玻璃深加工企业报价单管理系统. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>