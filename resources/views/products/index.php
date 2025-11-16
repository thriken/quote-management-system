<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">产品管理</h1>
        <a href="/products/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新增产品
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">产品名称</th>
                    <th class="py-2 px-4 text-left">原料厂家</th>
                    <th class="py-2 px-4 text-left">单价</th>
                    <th class="py-2 px-4 text-left">计价单位</th>
                    <th class="py-2 px-4 text-left">产品类型</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= htmlspecialchars($product['name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($product['manufacturer']) ?></td>
                    <td class="py-2 px-4">¥<?= number_format($product['price'], 2) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($product['unit']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($product['type']) ?></td>
                    <td class="py-2 px-4">
                        <a href="/products/edit/<?= $product['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-5">编辑</a>
                        <a href="/products/delete/<?= $product['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个产品吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>