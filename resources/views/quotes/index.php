<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单管理</h1>
        <div class="flex space-x-2">
            <a href="/quotes/comparison" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                报价单对比
            </a>
            <a href="/quotes/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                新增报价单
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">客户</th>
                    <th class="py-2 px-4 text-left">分类</th>
                    <th class="py-2 px-4 text-left">版本</th>
                    <th class="py-2 px-4 text-left">状态</th>
                    <th class="py-2 px-4 text-left">创建时间</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotes as $quote): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <?= htmlspecialchars($customers[$quote['customer_id']]['short_name'] ?? $customers[$quote['customer_id']]['full_name'] ?? '未知客户') ?>
                    </td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['category']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['version']) ?></td>
                    <td class="py-2 px-4">
                        <?php if ($quote['is_active']): ?>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">生效</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">未生效</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['created_at']) ?></td>
                    <td class="py-2 px-4">
                        <a href="/quotes/<?= $quote['id'] ?>/items" class="text-green-600 hover:text-green-900 mr-3">管理项目</a>
                        <a href="/quotes/edit/<?= $quote['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">编辑</a>
                        <a href="/quotes/delete/<?= $quote['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个报价单吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>