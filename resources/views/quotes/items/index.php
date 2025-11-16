<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单项目管理 - <?= htmlspecialchars($quote['version']) ?></h1>
        <a href="/quotes/<?= $quote['id'] ?>/items/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            新增项目
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">产品名称</th>
                    <th class="py-2 px-4 text-left">数量</th>
                    <th class="py-2 px-4 text-left">单价</th>
                    <th class="py-2 px-4 text-left">折扣率</th>
                    <th class="py-2 px-4 text-left">小计</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($items as $item): 
                    $product = $products[$item['product_id']] ?? null;
                    $subtotal = $item['quantity'] * $item['unit_price'] * (1 - $item['discount_rate'] / 100);
                    $total += $subtotal;
                ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= $product ? htmlspecialchars($product['name']) : '未知产品' ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($item['quantity']) ?></td>
                    <td class="py-2 px-4">¥<?= number_format($item['unit_price'], 2) ?></td>
                    <td class="py-2 px-4"><?= number_format($item['discount_rate'], 2) ?>%</td>
                    <td class="py-2 px-4">¥<?= number_format($subtotal, 2) ?></td>
                    <td class="py-2 px-4">
                        <a href="/quotes/<?= $quote['id'] ?>/items/edit/<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-5">编辑</a>
                        <a href="/quotes/<?= $quote['id'] ?>/items/delete/<?= $item['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个项目吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr class="border-b bg-gray-100 font-bold">
                    <td class="py-2 px-4" colspan="4">总计</td>
                    <td class="py-2 px-4">¥<?= number_format($total, 2) ?></td>
                    <td class="py-2 px-4"></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        <a href="/quotes" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            返回报价单列表
        </a>
    </div>
</div>