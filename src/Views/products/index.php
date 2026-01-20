<?php
$title = '产品中心 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>产品中心</h2>
    <p>覆盖多个出口品类，支持供应商筛选、价格对比与样品申请。</p>

    <div class="filters">
        <?php foreach ($categories as $category): ?>
            <span class="tag"><?= htmlspecialchars($category['name']) ?></span>
        <?php endforeach; ?>
    </div>

    <div class="grid">
        <?php foreach ($products as $product): ?>
            <article class="card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>类目：<?= htmlspecialchars($product['category_name']) ?></p>
                <p>供应商：<?= htmlspecialchars($product['supplier_name']) ?></p>
                <p class="price"><?= number_format((float) $product['price'], 2) ?> <?= htmlspecialchars($product['currency']) ?></p>
                <p>MOQ：<?= (int) $product['min_order'] ?> <?= htmlspecialchars($product['moq_unit']) ?></p>
                <div class="card-actions">
                    <a href="/product?slug=<?= urlencode($product['slug']) ?>">查看详情</a>
                    <form action="/cart" method="post">
                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                        <input type="hidden" name="quantity" value="<?= (int) $product['min_order'] ?>">
                        <button type="submit">加入采购清单</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
