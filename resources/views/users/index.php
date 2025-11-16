<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">用户管理</h1>
        <a href="/users/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新增用户
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">用户名</th>
                    <th class="py-2 px-4 text-left">姓名</th>
                    <th class="py-2 px-4 text-left">角色</th>
                    <th class="py-2 px-4 text-left">邮箱</th>
                    <th class="py-2 px-4 text-left">创建时间</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="py-2 px-4">
                        <a href="/users/edit/<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-5">编辑</a>
                        <a href="/users/delete/<?= $user['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个用户吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>