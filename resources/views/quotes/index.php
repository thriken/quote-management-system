<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">报价单管理</h1>
        <div class="flex space-x-2">
            <a href="/quotes/comparison" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" id="compare-link">
                报价单对比
            </a>
            <a href="/quotes/create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                新增报价单
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">客户</th>
                    <th class="py-2 px-4 text-left">分类</th>
                    <th class="py-2 px-4 text-left">版本</th>
                    <th class="py-2 px-4 text-left">状态</th>
                    <th class="py-2 px-4 text-left">创建时间</th>
                    <th class="py-2 px-4 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotes as $quote): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <?= htmlspecialchars($customers[$quote['customer_id']]['short_name'] ?? $customers[$quote['customer_id']]['full_name'] ?? '未知客户') ?>
                    </td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['category']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['version']) ?></td>
                    <td class="py-2 px-4">
                        <?php if ($quote['is_active']): ?>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">生效</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">未生效</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-2 px-4"><?= htmlspecialchars($quote['created_at']) ?></td>
                    <td class="py-2 px-4">
                        <button type="button" class="add-to-compare text-yellow-600 hover:text-yellow-900 mr-3" data-quote-id="<?= $quote['id'] ?>" data-quote-version="<?= htmlspecialchars($quote['version']) ?>">
                            添加对比
                        </button>
                        <a href="/quotes/<?= $quote['id'] ?>/items" class="text-green-600 hover:text-green-900 mr-3">管理项目</a>
                        <a href="/quotes/edit/<?= $quote['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">编辑</a>
                        <a href="/quotes/delete/<?= $quote['id'] ?>" class="text-red-600 hover:text-red-900" 
                           onclick="return confirm('确定要删除这个报价单吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// 报价单对比功能
let compareList = [];

// 从localStorage加载对比列表
function loadCompareList() {
    const saved = localStorage.getItem('quoteCompareList');
    if (saved) {
        compareList = JSON.parse(saved);
    }
    updateCompareButton();
}

// 保存对比列表到localStorage
function saveCompareList() {
    localStorage.setItem('quoteCompareList', JSON.stringify(compareList));
    updateCompareButton();
}

// 更新对比按钮显示
function updateCompareButton() {
    const compareButton = document.getElementById('compare-link');
    if (compareList.length > 0) {
        compareButton.textContent = `报价单对比 (${compareList.length})`;
        // 更新链接以传递对比列表中的报价单ID
        const ids = compareList.map(item => item.id).join(',');
        compareButton.href = `/quotes/comparison?compare_ids=${ids}`;
    } else {
        compareButton.textContent = '报价单对比';
        compareButton.href = '/quotes/comparison';
    }
}

// 添加到对比列表
document.querySelectorAll('.add-to-compare').forEach(button => {
    button.addEventListener('click', function() {
        const quoteId = this.getAttribute('data-quote-id');
        const quoteVersion = this.getAttribute('data-quote-version');
        
        // 检查是否已存在
        const existingIndex = compareList.findIndex(item => item.id == quoteId);
        if (existingIndex !== -1) {
            // 如果已存在，移除它
            compareList.splice(existingIndex, 1);
            this.textContent = '添加对比';
            this.classList.remove('text-yellow-900');
            this.classList.add('text-yellow-600');
        } else {
            // 检查是否已达到最大数量
            if (compareList.length >= 8) {
                alert('最多只能选择8个报价单进行对比');
                return;
            }
            // 添加到列表
            compareList.push({
                id: quoteId,
                version: quoteVersion
            });
            this.textContent = '已添加';
            this.classList.remove('text-yellow-600');
            this.classList.add('text-yellow-900');
        }
        
        saveCompareList();
    });
});

// 页面加载时初始化
document.addEventListener('DOMContentLoaded', function() {
    loadCompareList();
    
    // 更新按钮状态
    compareList.forEach(item => {
        const button = document.querySelector(`.add-to-compare[data-quote-id="${item.id}"]`);
        if (button) {
            button.textContent = '已添加';
            button.classList.remove('text-yellow-600');
            button.classList.add('text-yellow-900');
        }
    });
});
</script>