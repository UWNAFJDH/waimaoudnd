<?php require dirname(__DIR__) . '/../partials/header.php'; ?>

<section class="section feature-hero">
    <div>
        <h1>外贸平台功能全景（AppH5 可打包）</h1>
        <p>以下规划覆盖 100000+ 细分功能点（前端 50000+，后端 50000+），采用按需生成与分页加载，避免占用大量内存。</p>
        <div class="hero-actions">
            <a class="secondary" href="/resources">外贸资源</a>
            <a class="primary" href="/inquiry">提交 RFQ</a>
        </div>
    </div>
    <div class="feature-metrics">
        <div>
            <span class="metric">50000+</span>
            <p>前端功能细项（<?= $frontendTotal ?>）</p>
        </div>
        <div>
            <span class="metric">50000+</span>
            <p>后端功能细项（<?= $backendTotal ?>）</p>
        </div>
        <div>
            <span class="metric">AppH5</span>
            <p>支持 PWA &amp; H5 打包</p>
        </div>
    </div>
</section>

<section class="section">
    <h2>前端功能分类（示例细节）</h2>
    <div class="feature-toolbar">
        <label class="feature-search">
            <span>搜索功能点</span>
            <input id="feature-search" type="search" placeholder="输入关键词，例如：物流、询盘、税率、PWA">
        </label>
        <a class="secondary" href="/features?format=json&side=frontend&category=多语言与本地化">导出 JSON</a>
    </div>
    <p class="muted">共计 <?= $frontendTotal ?> 条前端功能点，默认每类加载 <?= $pageSize ?> 条，按需加载更多。</p>
    <div class="feature-grid">
        <?php foreach ($frontendCategories as $category): ?>
            <article class="feature-card" data-side="frontend" data-category="<?= htmlspecialchars($category['name']) ?>" data-page="<?= $category['page'] ?>" data-total="<?= $category['total'] ?>">
                <h3><?= htmlspecialchars($category['name']) ?></h3>
                <p class="muted">共 <?= $category['total'] ?> 条</p>
                <p><?= htmlspecialchars($category['summary']) ?></p>
                <details class="feature-details">
                    <summary>展开查看全部功能点</summary>
                    <ul class="feature-list">
                        <?php foreach ($category['items'] as $item): ?>
                            <li class="feature-item">
                                <strong><?= htmlspecialchars($item['title']) ?></strong>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                                <ul class="feature-sublist">
                                    <?php foreach ($item['deliverables'] as $deliverable): ?>
                                        <li><?= htmlspecialchars($deliverable) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <button class="secondary feature-load-more" type="button">加载更多</button>
                </details>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section highlight">
    <h2>后端功能域（示例细节）</h2>
    <p class="muted">共计 <?= $backendTotal ?> 条后端功能点，支持多租户扩展与分段加载。</p>
    <div class="feature-grid">
        <?php foreach ($backendDomains as $domain): ?>
            <article class="feature-card alt" data-side="backend" data-category="<?= htmlspecialchars($domain['name']) ?>" data-page="<?= $domain['page'] ?>" data-total="<?= $domain['total'] ?>">
                <h3><?= htmlspecialchars($domain['name']) ?></h3>
                <p class="muted">共 <?= $domain['total'] ?> 条</p>
                <p><?= htmlspecialchars($domain['summary']) ?></p>
                <details class="feature-details">
                    <summary>展开查看全部功能点</summary>
                    <ul class="feature-list">
                        <?php foreach ($domain['items'] as $item): ?>
                            <li class="feature-item">
                                <strong><?= htmlspecialchars($item['title']) ?></strong>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                                <ul class="feature-sublist">
                                    <?php foreach ($item['deliverables'] as $deliverable): ?>
                                        <li><?= htmlspecialchars($deliverable) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <button class="secondary feature-load-more" type="button">加载更多</button>
                </details>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section feature-cta">
    <div>
        <h2>需要完整 100000+ 功能清单与 PRD？</h2>
        <p>可提供详细功能矩阵、模块拆分与交互原型，支持 AppH5 打包与跨端交付。</p>
    </div>
    <a class="primary" href="/inquiry">联系方案团队</a>
</section>

<?php require dirname(__DIR__) . '/../partials/footer.php'; ?>
