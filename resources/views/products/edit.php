<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">编辑产品</h1>

    <form action="/products/<?= $product['id'] ?>" method="POST" class="space-y-4">
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">产品名称</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="manufacturer">原料厂家</label>
                <input type="text" id="manufacturer" name="manufacturer" value="<?= htmlspecialchars($product['manufacturer']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">单价</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product['price']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="unit">计价单位</label>
                <input type="text" id="unit" name="unit" value="<?= htmlspecialchars($product['unit']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">产品类型</label>
                <input type="text" id="type" name="type" value="<?= htmlspecialchars($product['type']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/products" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                取消
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                保存
            </button>
        </div>
    </form>
</div>