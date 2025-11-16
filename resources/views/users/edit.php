<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">编辑用户</h1>

    <form action="/users/<?= $user['id'] ?>" method="POST" class="space-y-4">
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">用户名</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">姓名</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">邮箱</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">角色</label>
                <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">请选择角色</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>" <?= $role == $user['role'] ? 'selected' : '' ?>><?= $role ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">新密码（留空则不修改）</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirm">确认新密码</label>
                <input type="password" id="password_confirm" name="password_confirm" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/users" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                取消
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                保存
            </button>
        </div>
    </form>
</div>