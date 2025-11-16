<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">编辑客户</h1>

    <form action="/customers/<?= $customer['id'] ?>" method="POST" class="space-y-4">
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="code">速记码</label>
                <input type="text" id="code" name="code" value="<?= htmlspecialchars($customer['code']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="short_name">客户简称</label>
                <input type="text" id="short_name" name="short_name" value="<?= htmlspecialchars($customer['short_name']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">客户全称</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="company_name">单位名称</label>
                <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($customer['company_name']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">联系电话</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="level">客户级别</label>
                <input type="text" id="level" name="level" value="<?= htmlspecialchars($customer['level']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">客户地址</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($customer['address']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="credit_code">统一社会信用代码</label>
                <input type="text" id="credit_code" name="credit_code" value="<?= htmlspecialchars($customer['credit_code']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bank">开户银行</label>
                <input type="text" id="bank" name="bank" value="<?= htmlspecialchars($customer['bank']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="account_number">账号+行号</label>
                <input type="text" id="account_number" name="account_number" value="<?= htmlspecialchars($customer['account_number']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/customers" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                取消
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                保存
            </button>
        </div>
    </form>
</div>