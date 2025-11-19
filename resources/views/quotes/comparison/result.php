<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单对比结果</h1>
        <div class="flex space-x-2">
            <!-- 生成直接访问链接 -->
            <?php 
            $quoteIds = array_keys($quotes);
            $uriParam = implode('_', $quoteIds);
            ?>
            <a href="/quotes/comparison/<?= $uriParam ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" target="_blank">
                直接访问此对比
            </a>
            <a href="/quotes/comparison" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                重新选择
            </a>
        </div>
    </div>

    <!-- 报价单信息对比 -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">报价单基本信息</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-200">
                    <tr>
                        <th colspan="2" class="py-2 px-4 border">报价单版本号</th>
                        <?php foreach ($quotes as $quote): ?>
                        <th class="colspan-1 py-2 px-4 border">版本号：<?= htmlspecialchars($quote['version']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="py-2 px-4 border font-medium">客户</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="colspan-1 py-2 px-4 border">
                            <?= htmlspecialchars($customers[$quote['customer_id']]['short_name'] ?? $customers[$quote['customer_id']]['full_name'] ?? '未知客户') ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="2" class="py-2 px-4 border font-medium">分类</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="colspan-1 py-2 px-4 border"><?= htmlspecialchars($quote['category']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2 px-4 border font-medium">状态</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="colspan-1 py-2 px-4 border">
                            <?php if ($quote['is_active']): ?>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">生效</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">未生效</span>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="2" class="py-2 px-4 border font-medium">折扣率</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="colspan-1 py-2 px-4 border"><?= number_format(is_numeric($quote['discount_rate']) ? $quote['discount_rate'] : 0, 2) ?>%</td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2 px-4 border font-medium">返点率</td>
                        <?php foreach ($quotes as $quote): ?>
                        <td class="colspan-1 py-2 px-4 border"><?= number_format(is_numeric($quote['rebate_rate']) ? $quote['rebate_rate'] : 0, 2) ?>%</td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
                <thead class="bg-gray-200">
                    <tr>
                        <th class="colspan-1 py-2 px-2 border">产品</th>
                        <th class="colspan-1 py-2 px-2 border">单位</th>
                        <?php foreach ($quotes as $quote): ?>
                        <th class="colspan-1 py-2 px-4 border">版本号：<?= htmlspecialchars($quote['version']) ?></th>
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
                    $rowIndex = 0;
                    // 显示每个产品在各报价单中的价格
                    foreach (array_keys($allProductIds) as $productId):
                        $product = $products[$productId] ?? null;
                        if (!$product) continue;
                        $rowClass = ($rowIndex % 2 == 0) ? 'bg-gray-50' : 'bg-white';
                        $rowIndex++;
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td class="colspan-1 py-2 px-2 border"><?= htmlspecialchars($product['name']) ?></td>
                            <td class="colspan-1 py-2 px-2 border"><?= htmlspecialchars($product['unit']) ?></td>
                            <?php 
                            // 获取第一个报价单的价格作为基准
                            $firstQuoteId = array_key_first($quotes);
                            $basePrice = null;
                            if (isset($items[$firstQuoteId])) {
                                foreach ($items[$firstQuoteId] as $item) {
                                    if ($item['product_id'] == $productId && is_numeric($item['unit_price'])) {
                                        $basePrice = (float)$item['unit_price'];
                                        break;
                                    }
                                }
                            }
                            
                            foreach ($quotes as $quote): ?>
                            <td class="colspan-1 py-2 px-4 border text-center">
                                <?php 
                                $itemPrice = 'N/A';
                                $displayPrice = 'N/A';
                                if (isset($items[$quote['id']])) {
                                    foreach ($items[$quote['id']] as $item) {
                                        if ($item['product_id'] == $productId) {
                                            if (is_numeric($item['unit_price'])) {
                                                $itemPrice = (float)$item['unit_price'];
                                                $displayPrice = '¥' . number_format($itemPrice, 2);
                                                
                                                // 如果不是第一个报价单且有基准价格，则显示差异
                                                if ($quote['id'] != $firstQuoteId && $basePrice !== null) {
                                                    $diff = $itemPrice - $basePrice;
                                                    if ($diff > 0) {
                                                        // 价格更高，显示红色和正差值
                                                        $displayPrice .= ' <span class="text-red-600">[+' . number_format($diff, 2) . '元]</span>';
                                                    } elseif ($diff < 0) {
                                                        // 价格更低，显示绿色和负差值
                                                        $displayPrice .= ' <span class="text-green-600">[' . number_format($diff, 2) . '元]</span>';
                                                    }
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }
                                echo $displayPrice;
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