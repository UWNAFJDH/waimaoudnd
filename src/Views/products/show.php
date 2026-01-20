<?php
$title = '产品详情 - ' . $product['name'];
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <div class="product-detail">
        <div>
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p class="price"><?= number_format((float) $product['price'], 2) ?> <?= htmlspecialchars($product['currency']) ?> / <?= htmlspecialchars($product['moq_unit']) ?></p>
            <p>起订量：<?= (int) $product['min_order'] ?> <?= htmlspecialchars($product['moq_unit']) ?></p>
            <p>交期：<?= htmlspecialchars($product['lead_time']) ?></p>
            <p>贸易条款：<?= htmlspecialchars($product['incoterms']) ?></p>
            <p>产地：<?= htmlspecialchars($product['origin']) ?></p>
            <div class="specs">
                <h4>产品描述</h4>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <h4>规格参数</h4>
                <p><?= htmlspecialchars($product['specs']) ?></p>
            </div>
            <form action="/cart" method="post" class="inline-form">
                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                <label>
                    采购数量
                    <input type="number" name="quantity" value="<?= (int) $product['min_order'] ?>" min="<?= (int) $product['min_order'] ?>">
                </label>
                <button type="submit">加入采购清单</button>
            </form>
            <a class="secondary" href="/inquiry?product_id=<?= (int) $product['id'] ?>">发起询盘</a>
        </div>
        <aside class="supplier-card">
            <h3>供应商信息</h3>
            <p><strong><?= htmlspecialchars($product['supplier_name']) ?></strong></p>
            <p>公司：<?= htmlspecialchars($product['supplier_name']) ?></p>
            <p>国家：<?= htmlspecialchars($product['supplier_country']) ?></p>
            <p>评级：<?= number_format((float) $product['supplier_rating'], 1) ?> / 5</p>
            <p>认证：<?= htmlspecialchars($product['supplier_certifications']) ?></p>
            <p>响应时间：<?= htmlspecialchars($product['supplier_response_time']) ?></p>
            <p><?= htmlspecialchars($product['supplier_description']) ?></p>
            <a href="/supplier?id=<?= (int) $product['supplier_id'] ?>">查看供应商档案</a>
        </aside>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
