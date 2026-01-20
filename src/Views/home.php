<?php
$title = 'GlobalTrade Hub - 外贸主页';
require __DIR__ . '/partials/header.php';
?>
<section class="hero">
    <div>
        <h1>链接全球制造力，让外贸成交更高效</h1>
        <p>整合 20,000+ 认证工厂、智能询盘与风控服务，帮助采购商快速匹配供应链。</p>
        <div class="hero-actions">
            <a class="primary" href="/products">浏览精选产品</a>
            <a class="secondary" href="/inquiry">发布采购需求</a>
        </div>
        <div class="hero-metrics">
            <div>
                <strong>160+</strong>
                <span>覆盖国家</span>
            </div>
            <div>
                <strong>48h</strong>
                <span>平均报价响应</span>
            </div>
            <div>
                <strong>98%</strong>
                <span>履约满意度</span>
            </div>
        </div>
    </div>
    <div class="hero-card">
        <h3>今日采购速报</h3>
        <ul>
            <li>欧洲客户寻找 5,000 pcs 智能仓储扫码设备</li>
            <li>中东采购商需求 10,000 套太阳能花园灯</li>
            <li>北美酒店集团采购有机棉床品</li>
        </ul>
        <p class="tagline">实时匹配 → 风险评估 → 成交跟进</p>
    </div>
</section>

<section class="section">
    <h2>热门类目</h2>
    <div class="grid">
        <?php foreach ($categories as $category): ?>
            <div class="card">
                <h3><?= htmlspecialchars($category['name']) ?></h3>
                <p>覆盖热门出口市场，支持多币种与HS编码匹配。</p>
                <a href="/products">查看类目</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <h2>最新上线产品</h2>
    <div class="grid">
        <?php foreach ($products as $product): ?>
            <article class="card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>供应商：<?= htmlspecialchars($product['supplier_name']) ?></p>
                <p class="price"><?= number_format((float) $product['price'], 2) ?> <?= htmlspecialchars($product['currency']) ?> / <?= htmlspecialchars($product['moq_unit']) ?></p>
                <p>起订量：<?= (int) $product['min_order'] ?> <?= htmlspecialchars($product['moq_unit']) ?></p>
                <a href="/product?slug=<?= urlencode($product['slug']) ?>">查看详情</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <h2>优选供应商</h2>
    <div class="grid">
        <?php foreach ($suppliers as $supplier): ?>
            <article class="card">
                <h3><?= htmlspecialchars($supplier['name']) ?></h3>
                <p>国家/地区：<?= htmlspecialchars($supplier['country']) ?></p>
                <p>评分：<?= number_format((float) $supplier['rating'], 1) ?> / 5</p>
                <p>响应时间：<?= htmlspecialchars($supplier['response_time']) ?></p>
                <a href="/supplier?id=<?= (int) $supplier['id'] ?>">查看企业档案</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section highlight">
    <h2>为什么选择 GlobalTrade Hub？</h2>
    <div class="grid">
        <div class="card">
            <h3>供应链透明</h3>
            <p>提供验厂报告、年审记录、出口资质与产能说明，降低采购风险。</p>
        </div>
        <div class="card">
            <h3>智能询盘管理</h3>
            <p>支持RFQ分发、智能跟进提醒、报价对比与谈判记录归档。</p>
        </div>
        <div class="card">
            <h3>贸易合规服务</h3>
            <p>覆盖关税、原产地证明、合规审核、付款与物流保险。</p>
        </div>
    </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
