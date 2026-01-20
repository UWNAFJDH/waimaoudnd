<?php
$title = '登录 - GlobalTrade Hub';
require __DIR__ . '/../partials/header.php';
?>
<section class="section">
    <h2>账号登录</h2>
    <p>演示账号：buyer@example.com / demo1234 或 admin@example.com / demo1234</p>
    <form class="form" action="/login" method="post">
        <label>
            邮箱
            <input type="email" name="email" required>
        </label>
        <label>
            密码
            <input type="password" name="password" required>
        </label>
        <button type="submit">登录</button>
    </form>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
