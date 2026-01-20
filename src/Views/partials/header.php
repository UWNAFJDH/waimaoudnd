<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'GlobalTrade 外贸平台' ?></title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script defer src="/assets/app.js"></script>
</head>
<body>
<header class="site-header">
    <div class="brand">
        <span class="logo">GT</span>
        <div>
            <strong>GlobalTrade Hub</strong>
            <small>全球外贸一站式平台</small>
        </div>
    </div>
    <nav>
        <a href="/">首页</a>
        <a href="/products">产品中心</a>
        <a href="/suppliers">供应商</a>
        <a href="/features">功能规划</a>
        <a href="/resources">外贸资源</a>
        <a href="/cart">采购清单</a>
        <?php if ($user): ?>
            <a href="/account">我的账号</a>
            <form action="/logout" method="post" class="inline-form">
                <button type="submit">退出</button>
            </form>
        <?php else: ?>
            <a href="/login">登录</a>
        <?php endif; ?>
    </nav>
</header>

<?php if ($flash): ?>
    <div class="flash-message"><?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<main>
