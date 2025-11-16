<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">客户管理</h1>
        <a href="/customers/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新增客户
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">速记码</th>
                    <th class="py-2 px-4 text-left">客户简称</th>
                    <th class="py-2 px-4 text-left">客户全称</th>
                    <th class="py-2 px-4 text-left">联系电话</th>
                    <th class="py-2 px-4 text-left">客户级别</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= htmlspecialchars($customer['code']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($customer['short_name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($customer['full_name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($customer['phone']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($customer['level']) ?></td>
                    <td class="py-2 px-4">
                        <a href="/customers/edit/<?= $customer['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-5">编辑</a>
                        <a href="/customers/delete/<?= $customer['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个客户吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>