<?php
$title = '供应商档案 - ' . $supplier['name'];
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <div class="supplier-detail">
        <div>
            <h2><?= htmlspecialchars($supplier['name']) ?></h2>
            <p>国家/地区：<?= htmlspecialchars($supplier['country']) ?></p>
            <p>评分：<?= number_format((float) $supplier['rating'], 1) ?> / 5</p>
            <p>认证：<?= htmlspecialchars($supplier['certifications']) ?></p>
            <p>响应时间：<?= htmlspecialchars($supplier['response_time']) ?></p>
            <p><?= htmlspecialchars($supplier['description']) ?></p>
            <?php if ((int) $supplier['verified'] === 1): ?>
                <span class="badge">平台验厂通过</span>
            <?php else: ?>
                <span class="badge warning">审核中</span>
            <?php endif; ?>
        </div>
        <div class="card">
            <h3>合作能力</h3>
            <ul>
                <li>年产能：120,000 件</li>
                <li>出口市场：欧美/中东/拉美</li>
                <li>可提供样品：3-5 天</li>
                <li>质量体系：ISO9001</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <h2>该供应商产品</h2>
    <div class="grid">
        <?php foreach ($products as $product): ?>
            <article class="card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="price"><?= number_format((float) $product['price'], 2) ?> <?= htmlspecialchars($product['currency']) ?></p>
                <p>MOQ：<?= (int) $product['min_order'] ?> <?= htmlspecialchars($product['moq_unit']) ?></p>
                <a href="/product?slug=<?= urlencode($product['slug']) ?>">查看详情</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
