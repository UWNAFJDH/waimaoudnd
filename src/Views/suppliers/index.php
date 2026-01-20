<?php
$title = '供应商 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>认证供应商</h2>
    <p>平台统一资质审核与年检，帮助采购商快速筛选高质量合作伙伴。</p>
    <div class="grid">
        <?php foreach ($suppliers as $supplier): ?>
            <article class="card">
                <h3><?= htmlspecialchars($supplier['name']) ?></h3>
                <p>国家/地区：<?= htmlspecialchars($supplier['country']) ?></p>
                <p>评级：<?= number_format((float) $supplier['rating'], 1) ?> / 5</p>
                <p>响应时间：<?= htmlspecialchars($supplier['response_time']) ?></p>
                <p>认证：<?= htmlspecialchars($supplier['certifications']) ?></p>
                <?php if ((int) $supplier['verified'] === 1): ?>
                    <span class="badge">已认证</span>
                <?php endif; ?>
                <a href="/supplier?id=<?= (int) $supplier['id'] ?>">查看详情</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
