# GlobalTrade Hub (PHP 外贸平台示例)

这是一个完整的外贸平台示例，涵盖产品中心、供应商档案、RFQ 询盘、采购清单、订单管理与后台概览等核心模块。

## 功能亮点
- 多类目产品展示与详情页
- 供应商验厂信息与合作能力
- 询盘提交与跟踪
- 采购清单与结算流程
- 登录、账号中心与订单管理
- 管理后台运营概览

## 本地运行
```bash
php -S 0.0.0.0:8000 -t public
```

浏览器访问：http://localhost:8000

> 演示账号：
> - buyer@example.com / demo1234
> - admin@example.com / demo1234

SQLite 数据库会自动初始化并写入 `data/app.db`。
