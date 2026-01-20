<?php
$title = '我的账号 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>欢迎回来，<?= htmlspecialchars($user['name']) ?></h2>
    <div class="grid">
        <div class="card">
            <h3>公司资料</h3>
            <p>公司：<?= htmlspecialchars($user['company']) ?></p>
            <p>国家：<?= htmlspecialchars($user['country']) ?></p>
            <p>邮箱：<?= htmlspecialchars($user['email']) ?></p>
            <p>角色：<?= htmlspecialchars($user['role']) ?></p>
        </div>
        <div class="card">
            <h3>待办事项</h3>
            <ul>
                <li>更新付款账户信息</li>
                <li>确认最新报价单</li>
                <li>提交年度合规文件</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <h2>订单管理</h2>
    <?php if (!$orders): ?>
        <p>暂无订单。</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>订单编号</th>
                    <th>状态</th>
                    <th>金额</th>
                    <th>物流方案</th>
                    <th>创建时间</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['reference']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><?= number_format((float) $order['total'], 2) ?> <?= htmlspecialchars($order['currency']) ?></td>
                        <td><?= htmlspecialchars($order['logistics']) ?></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
