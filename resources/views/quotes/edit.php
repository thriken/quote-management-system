<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">编辑报价单</h1>

    <form action="/quotes/<?= $quote['id'] ?>" method="POST" class="space-y-4">
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_id">客户</label>
                <select id="customer_id" name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">请选择客户</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>" <?= $customer['id'] == $quote['customer_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($customer['short_name'] ?? $customer['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category">分类</label>
                <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">请选择分类</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>" <?= $category == $quote['category'] ? 'selected' : '' ?>><?= $category ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="version">版本号</label>
                <input type="text" id="version" name="version" value="<?= htmlspecialchars($quote['version']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="is_active">是否生效</label>
                <select id="is_active" name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="0" <?= !$quote['is_active'] ? 'selected' : '' ?>>未生效</option>
                    <option value="1" <?= $quote['is_active'] ? 'selected' : '' ?>>生效</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="discount_rate">折扣率 (%)</label>
                <input type="number" id="discount_rate" name="discount_rate" step="0.01" min="0" max="100" value="<?= htmlspecialchars($quote['discount_rate']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="rebate_rate">返点率 (%)</label>
                <input type="number" id="rebate_rate" name="rebate_rate" step="0.01" min="0" max="100" value="<?= htmlspecialchars($quote['rebate_rate']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="effective_date">生效日期</label>
                <input type="date" id="effective_date" name="effective_date" value="<?= htmlspecialchars($quote['effective_date']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="expiry_date">失效日期</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?= htmlspecialchars($quote['expiry_date']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/quotes" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                取消
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                保存
            </button>
        </div>
    </form>
</div>