<?php
$title = '结算 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>结算与履约</h2>
    <p>请完善收货与物流方案，系统将生成采购订单与合同。</p>
    <form class="form">
        <label>
            目的港口
            <input type="text" placeholder="如：Shanghai, Hamburg" required>
        </label>
        <label>
            运输方式
            <select>
                <option>海运整柜</option>
                <option>海运拼箱</option>
                <option>空运快件</option>
            </select>
        </label>
        <label>
            支付条款
            <select>
                <option>30% 预付款 + 70% 出货前</option>
                <option>信用证 (L/C)</option>
                <option>OA 30 天</option>
            </select>
        </label>
        <label>
            贸易条款
            <select>
                <option>FOB</option>
                <option>CIF</option>
                <option>DDP</option>
            </select>
        </label>
        <label>
            备注需求
            <textarea rows="4" placeholder="包装、验货、发票等"></textarea>
        </label>
        <button type="button">生成订单草稿</button>
    </form>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
