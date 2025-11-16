<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">系统安装</h1>

    <?php if (isset($installed) && $installed): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">系统已经安装过了！</strong>
        </div>
    <?php else: ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">安装过程中出现错误：</strong>
                <ul class="list-disc pl-5 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($messages) && !empty($messages)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">安装信息：</strong>
                <ul class="list-disc pl-5 mt-2">
                    <?php foreach ($messages as $message): ?>
                        <li><?= htmlspecialchars($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ((!isset($errors) || empty($errors)) && (!isset($messages) || empty($messages))): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <p>点击下面的按钮开始安装系统。</p>
                <p class="mt-2 text-sm">注意：安装过程会创建数据库表并初始化数据，请确保数据库配置正确。</p>
            </div>
        <?php endif; ?>

        <form action="/install" method="POST" class="space-y-4">
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($messages) && !empty($messages)): ?>
                        重新安装
                    <?php else: ?>
                        开始安装
                    <?php endif; ?>
                </button>
                
                <?php if (isset($messages) && !empty($messages)): ?>
                    <a href="/login" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        前往登录
                    </a>
                <?php endif; ?>
            </div>
        </form>
    <?php endif; ?>
</div>