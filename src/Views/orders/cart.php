<?php
$title = '采购清单 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>采购清单</h2>
    <?php if (!$items): ?>
        <p>暂无加入的产品，先去产品中心挑选吧。</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>产品</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>小计</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product']['name']) ?></td>
                        <td><?= (int) $item['quantity'] ?></td>
                        <td><?= number_format((float) $item['product']['price'], 2) ?> <?= htmlspecialchars($item['product']['currency']) ?></td>
                        <td><?= number_format((float) $item['subtotal'], 2) ?> <?= htmlspecialchars($item['product']['currency']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="summary">
            <strong>预估总额：<?= number_format((float) $total, 2) ?> USD</strong>
            <a class="primary" href="/checkout">进入结算</a>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
