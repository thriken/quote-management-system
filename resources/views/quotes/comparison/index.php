<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单对比</h1>
    </div>

    <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
    </div>
    <?php endif; ?>

    <form action="/quotes/comparison" method="POST">
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">选择要对比的报价单（至少选择两个）</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($quotes as $quote): ?>
                <div class="border rounded-lg p-4 hover:bg-gray-50">
                    <label class="flex items-center">
                        <input type="checkbox" name="quote_ids[]" value="<?= $quote['id'] ?>" class="mr-2 h-5 w-5 text-blue-600">
                        <div>
                            <div class="font-medium"><?= htmlspecialchars($quote['version']) ?></div>
                            <div class="text-sm text-gray-600">
                                <?= htmlspecialchars($customers[$quote['customer_id']]['short_name'] ?? $customers[$quote['customer_id']]['full_name'] ?? '未知客户') ?>
                            </div>
                            <div class="text-xs text-gray-500"><?= htmlspecialchars($quote['created_at']) ?></div>
                        </div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                开始对比
            </button>
        </div>
    </form>
</div>