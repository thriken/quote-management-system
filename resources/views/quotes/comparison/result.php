<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单对比结果</h1>
        <a href="/quotes/comparison" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            重新选择
        </a>
    </div>

    <!-- 报价单信息对比 -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">报价单基本信息</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">信息</th>
                        <?php foreach ($quotes as $quote): ?>
                        <th class="py-2 px-4 border"><?= htmlspecialchars($quote['version']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border font-medium">客户</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border">
                            <?= htmlspecialchars($customers[$quote['customer_id']]['short_name'] ?? $customers[$quote['customer_id']]['full_name'] ?? '未知客户') ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-2 px-4 border font-medium">分类</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($quote['category']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border font-medium">状态</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border">
                            <?php if ($quote['is_active']): ?>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">生效</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">未生效</span>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="py-2 px-4 border font-medium">折扣率</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border"><?= number_format($quote['discount_rate'], 2) ?>%</td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border font-medium">返点率</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border"><?= number_format($quote['rebate_rate'], 2) ?>%</td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 产品项目对比 -->
    <div>
        <h2 class="text-xl font-bold mb-4">产品项目对比</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">产品</th>
                        <th class="py-2 px-4 border">单位</th>
                        <?php foreach ($quotes as $quote): ?>
                        <th class="py-2 px-4 border"><?= htmlspecialchars($quote['version']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // 收集所有产品ID
                    $allProductIds = [];
                    foreach ($items as $quoteItems) {
                        foreach ($quoteItems as $item) {
                            $allProductIds[$item['product_id']] = true;
                        }
                    }
                    
                    // 显示每个产品在各报价单中的价格
                    foreach (array_keys($allProductIds) as $productId):
                        $product = $products[$productId] ?? null;
                        if (!$product) continue;
                    ?>
                    <tr class="<?= isset($rowClass) && $rowClass == 'bg-gray-50' ? ($rowClass = '') : ($rowClass = 'bg-gray-50') ?>">
                        <td class="py-2 px-4 border"><?= htmlspecialchars($product['name']) ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($product['unit']) ?></td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="py-2 px-4 border text-center">
                            <?php 
                            $itemPrice = 'N/A';
                            if (isset($items[$quote['id']])) {
                                foreach ($items[$quote['id']] as $item) {
                                    if ($item['product_id'] == $productId) {
                                        $itemPrice = '¥' . number_format($item['unit_price'], 2);
                                        break;
                                    }
                                }
                            }
                            echo $itemPrice;
                            ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>