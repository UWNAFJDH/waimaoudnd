<?php

declare(strict_types=1);

namespace App\Controllers;

final class FeatureController extends Controller
{
    private const FRONTEND_TOTAL = 50000;
    private const BACKEND_TOTAL = 50000;
    private const DEFAULT_PAGE_SIZE = 20;

    public function index(): void
    {
        if (isset($_GET['format']) && $_GET['format'] === 'json') {
            $this->handleJson();
            return;
        }

        $frontendCategories = $this->buildCategorySummaries(
            $this->frontendCategoryNames(),
            self::FRONTEND_TOTAL,
            self::DEFAULT_PAGE_SIZE,
            'frontend'
        );
        $backendDomains = $this->buildCategorySummaries(
            $this->backendCategoryNames(),
            self::BACKEND_TOTAL,
            self::DEFAULT_PAGE_SIZE,
            'backend'
        );

        $this->view('features/index', [
            'frontendCategories' => $frontendCategories,
            'backendDomains' => $backendDomains,
            'frontendTotal' => self::FRONTEND_TOTAL,
            'backendTotal' => self::BACKEND_TOTAL,
            'pageSize' => self::DEFAULT_PAGE_SIZE,
        ]);
    }

    private function handleJson(): void
    {
        $side = $_GET['side'] ?? 'frontend';
        $category = $_GET['category'] ?? '';
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $per = max(1, min(100, (int) ($_GET['per'] ?? self::DEFAULT_PAGE_SIZE)));
        $categories = $side === 'backend' ? $this->backendCategoryNames() : $this->frontendCategoryNames();
        $total = $side === 'backend' ? self::BACKEND_TOTAL : self::FRONTEND_TOTAL;

        if (!in_array($category, $categories, true)) {
            $category = $categories[0] ?? '';
        }

        $countMap = $this->categoryCounts($categories, $total);
        $categoryTotal = $countMap[$category] ?? 0;
        $offset = ($page - 1) * $per;
        $items = $offset < $categoryTotal ? $this->buildFeatureItems($category, $offset, $per, $side) : [];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'side' => $side,
            'category' => $category,
            'page' => $page,
            'per' => $per,
            'category_total' => $categoryTotal,
            'items' => $items,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function buildCategorySummaries(array $categories, int $total, int $per, string $side): array
    {
        $counts = $this->categoryCounts($categories, $total);
        $summaries = [];

        foreach ($categories as $category) {
            $summaries[] = [
                'name' => $category,
                'summary' => $this->categorySummary($category),
                'total' => $counts[$category] ?? 0,
                'page' => 1,
                'items' => $this->buildFeatureItems($category, 0, $per, $side),
            ];
        }

        return $summaries;
    }

    private function categoryCounts(array $categories, int $total): array
    {
        $countMap = [];
        $count = count($categories);
        $base = intdiv($total, $count);
        $remainder = $total % $count;

        foreach ($categories as $index => $category) {
            $countMap[$category] = $base + ($index < $remainder ? 1 : 0);
        }

        return $countMap;
    }

    private function frontendCategoryNames(): array
    {
        return [
            '多语言与本地化',
            '产品中心与搜索',
            '供应商展示',
            'RFQ 询盘与报价',
            '交易与订单管理',
            '营销与增长',
            '信任与安全',
            'App/H5 打包支持',
            '客户服务与IM',
            '数据洞察与看板',
        ];
    }

    private function backendCategoryNames(): array
    {
        return [
            '用户与权限',
            '商品与类目服务',
            '供应商与工厂',
            '询盘与报价引擎',
            '订单与结算',
            '物流与履约',
            '数据与分析',
            '平台与运维',
            '风控与合规',
            '开放平台与集成',
        ];
    }

    private function categorySummary(string $category): string
    {
        $summaries = [
            '多语言与本地化' => '语言、币种、税率与合规提示全链路覆盖。',
            '产品中心与搜索' => '面向采购商的检索、对比与决策支持。',
            '供应商展示' => '展示认证、产能与服务能力。',
            'RFQ 询盘与报价' => '覆盖询盘提交、分发、报价与追踪。',
            '交易与订单管理' => '订单、支付与履约协同。',
            '营销与增长' => '营销活动、线索转化与增长运营。',
            '信任与安全' => '风控、隐私、合规与安全体系。',
            'App/H5 打包支持' => '移动端体验、PWA 与打包能力。',
            '客户服务与IM' => '售前售后与多渠道沟通。',
            '数据洞察与看板' => '经营指标与实时看板。',
            '用户与权限' => '账号体系与权限矩阵。',
            '商品与类目服务' => 'SKU、类目与属性模型。',
            '供应商与工厂' => '入驻审核、产能与绩效。',
            '询盘与报价引擎' => '询盘分发、报价与规则引擎。',
            '订单与结算' => '订单拆分与多币种结算。',
            '物流与履约' => '承运商对接与履约追踪。',
            '数据与分析' => '报表、BI 与指标体系。',
            '平台与运维' => '运维监控与可用性保障。',
            '风控与合规' => '风险识别与合规治理。',
            '开放平台与集成' => 'API 网关与第三方系统对接。',
        ];

        return $summaries[$category] ?? '功能模块完整覆盖核心业务链路。';
    }

    private function buildFeatureItems(string $category, int $offset, int $limit, string $side): array
    {
        $templates = $side === 'backend'
            ? [
                '实现%s，支持%s业务流',
                '新增%s，保障%s稳定',
                '完善%s，满足%s合规',
                '%s引擎升级，覆盖%s场景',
                '提供%s，强化%s可追溯',
            ]
            : [
                '支持%s，提供%s体验',
                '新增%s，提升%s效率',
                '提供%s，确保%s一致',
                '%s流程优化，保障%s可用',
                '%s模块完善，覆盖%s场景',
            ];
        $details = $side === 'backend'
            ? [
                '权限矩阵配置',
                'SKU 属性模版',
                '验厂报告归档',
                'RFQ 分发规则',
                '订单拆单逻辑',
                '多币种结算',
                '承运商接口同步',
                '数据指标口径',
                '日志审计链路',
                '黑名单策略',
                'API 网关限流',
                'Webhook 订阅',
                '通知任务调度',
                '合同模板管理',
                '风控评分模型',
                '对账单生成',
                '税务字段映射',
                '仓储入库校验',
            ]
            : [
                '语言包切换',
                '币种与税率展示',
                '规格对比表',
                '询盘模板配置',
                '订单状态节点',
                '物流轨迹可视化',
                '营销活动落地页',
                '企业认证展示',
                'PWA 缓存策略',
                '客服IM快捷回复',
                '移动端手势交互',
                '附件上传压缩',
                '消息中心提醒',
                '样品申请流程',
                '供方评分标签',
                '账号资料完整度',
                '优惠券发放',
                '退货/换货入口',
                '合同下载专区',
            ];
        $values = [
            '多区域运营',
            '跨端一致性',
            '业务协同',
            '交付效率',
            '客户留存',
            '风控安全',
            '合规审计',
            '数据可视化',
            '全球支付',
            '自动化处理',
        ];

        $items = [];
        for ($index = 0; $index < $limit; $index++) {
            $sequence = $offset + $index + 1;
            $detail = $details[$sequence % count($details)];
            $value = $values[$sequence % count($values)];
            $template = $templates[$sequence % count($templates)];
            $title = sprintf('%s 功能项 %05d', $category, $sequence);
            $items[] = [
                'id' => $sequence,
                'category' => $category,
                'title' => $title,
                'description' => sprintf($template, $detail, $value),
                'deliverables' => [
                    sprintf('流程节点: %s', $detail),
                    sprintf('校验规则: %s', $value),
                    '提示语: 完整说明与可视化',
                ],
            ];
        }

        return $items;
    }
}
