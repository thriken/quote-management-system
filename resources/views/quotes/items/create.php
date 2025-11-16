<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">新增报价单项目 - <?= htmlspecialchars($quote['version']) ?></h1>

    <form action="/quotes/<?= $quote['id'] ?>/items" method="POST" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="product_id">产品</label>
                <select id="product_id" name="product_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">请选择产品</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>">
                            <?= htmlspecialchars($product['name']) ?> (¥<?= number_format($product['price'], 2) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">数量</label>
                <input type="number" id="quantity" name="quantity" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="unit_price">单价</label>
                <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="discount_rate">折扣率 (%)</label>
                <input type="number" id="discount_rate" name="discount_rate" step="0.01" min="0" max="100" value="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/quotes/<?= $quote['id'] ?>/items" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                取消
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                保存
            </button>
        </div>
    </form>
</div>

<script>
// 当选择产品时，自动填充单价
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    if (price) {
        document.getElementById('unit_price').value = price;
    }
});
</script>