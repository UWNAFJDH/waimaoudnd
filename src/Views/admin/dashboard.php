<?php
$title = '管理后台 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>运营总览</h2>
    <div class="grid">
        <div class="card">
            <h3>注册用户</h3>
            <p class="metric"><?= (int) $metrics['users'] ?></p>
        </div>
        <div class="card">
            <h3>认证供应商</h3>
            <p class="metric"><?= (int) $metrics['suppliers'] ?></p>
        </div>
        <div class="card">
            <h3>产品数量</h3>
            <p class="metric"><?= (int) $metrics['products'] ?></p>
        </div>
        <div class="card">
            <h3>未处理询盘</h3>
            <p class="metric"><?= (int) $metrics['inquiries'] ?></p>
        </div>
    </div>
</section>

<section class="section">
    <h2>最新询盘</h2>
    <table class="table">
        <thead>
            <tr>
                <th>联系人</th>
                <th>产品</th>
                <th>数量</th>
                <th>状态</th>
                <th>提交时间</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inquiries as $inquiry): ?>
                <tr>
                    <td><?= htmlspecialchars($inquiry['name']) ?></td>
                    <td><?= htmlspecialchars($inquiry['product_name'] ?? '自定义需求') ?></td>
                    <td><?= (int) $inquiry['quantity'] ?></td>
                    <td><?= htmlspecialchars($inquiry['status']) ?></td>
                    <td><?= htmlspecialchars($inquiry['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
