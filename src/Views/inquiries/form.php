<?php
$title = '提交询盘 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>提交采购询盘</h2>
    <p>填写需求信息，我们会在24小时内为您匹配供应商。</p>
    <form class="form" action="/inquiry" method="post">
        <label>
            联系人姓名
            <input type="text" name="name" required>
        </label>
        <label>
            联系邮箱
            <input type="email" name="email" required>
        </label>
        <label>
            公司名称
            <input type="text" name="company">
        </label>
        <label>
            目标产品
            <input type="text" value="<?= $product ? htmlspecialchars($product['name']) : '' ?>" placeholder="可填写产品名称">
        </label>
        <input type="hidden" name="product_id" value="<?= $product ? (int) $product['id'] : '' ?>">
        <label>
            需求数量
            <input type="number" name="quantity" min="1" required>
        </label>
        <label>
            目标单价 (USD)
            <input type="number" step="0.01" name="target_price">
        </label>
        <label>
            需求说明
            <textarea name="message" rows="5" placeholder="交期、认证、包装等"></textarea>
        </label>
        <button type="submit">提交询盘</button>
    </form>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
