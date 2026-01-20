<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $dbPath = dirname(__DIR__) . '/data/app.db';
        $isNew = !file_exists($dbPath);

        self::$connection = new PDO('sqlite:' . $dbPath);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($isNew) {
            self::migrate();
            self::seed();
        }

        return self::$connection;
    }

    private static function migrate(): void
    {
        $schema = [
            'CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT "buyer",
                company TEXT,
                country TEXT,
                created_at TEXT NOT NULL
            )',
            'CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE
            )',
            'CREATE TABLE suppliers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                country TEXT NOT NULL,
                rating REAL NOT NULL,
                certifications TEXT,
                response_time TEXT,
                verified INTEGER NOT NULL DEFAULT 0,
                description TEXT
            )',
            'CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                category_id INTEGER NOT NULL,
                supplier_id INTEGER NOT NULL,
                price REAL NOT NULL,
                currency TEXT NOT NULL,
                min_order INTEGER NOT NULL,
                moq_unit TEXT NOT NULL,
                lead_time TEXT NOT NULL,
                incoterms TEXT NOT NULL,
                origin TEXT NOT NULL,
                description TEXT,
                specs TEXT,
                created_at TEXT NOT NULL,
                FOREIGN KEY(category_id) REFERENCES categories(id),
                FOREIGN KEY(supplier_id) REFERENCES suppliers(id)
            )',
            'CREATE TABLE inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                company TEXT,
                product_id INTEGER,
                quantity INTEGER NOT NULL,
                target_price REAL,
                message TEXT,
                status TEXT NOT NULL DEFAULT "new",
                created_at TEXT NOT NULL,
                FOREIGN KEY(product_id) REFERENCES products(id)
            )',
            'CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                reference TEXT NOT NULL,
                status TEXT NOT NULL,
                total REAL NOT NULL,
                currency TEXT NOT NULL,
                logistics TEXT NOT NULL,
                payment_terms TEXT NOT NULL,
                created_at TEXT NOT NULL,
                FOREIGN KEY(user_id) REFERENCES users(id)
            )',
            'CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                product_id INTEGER NOT NULL,
                quantity INTEGER NOT NULL,
                unit_price REAL NOT NULL,
                FOREIGN KEY(order_id) REFERENCES orders(id),
                FOREIGN KEY(product_id) REFERENCES products(id)
            )',
        ];

        foreach ($schema as $statement) {
            self::$connection->exec($statement);
        }
    }

    private static function seed(): void
    {
        $now = date('c');
        $password = password_hash('demo1234', PASSWORD_DEFAULT);
        $userStmt = self::$connection->prepare('INSERT INTO users (name, email, password, role, company, country, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $userStmt->execute(['Demo Buyer', 'buyer@example.com', $password, 'buyer', 'Pacific Imports', 'China', $now]);
        $userStmt->execute(['Admin Manager', 'admin@example.com', $password, 'admin', 'GlobalTrade HQ', 'Singapore', $now]);

        $categories = [
            ['Industrial Machinery', 'industrial-machinery'],
            ['Consumer Electronics', 'consumer-electronics'],
            ['Home & Garden', 'home-garden'],
            ['Textiles & Apparel', 'textiles-apparel'],
        ];
        $catStmt = self::$connection->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
        foreach ($categories as $category) {
            $catStmt->execute($category);
        }

        $suppliers = [
            ['Shenzhen Tech Manufacturing', 'China', 4.8, 'ISO9001, CE, RoHS', '≤ 4 hrs', 1, 'Smart device OEM/ODM with in-house R&D and multilingual support.'],
            ['VietBuild Industrial Co.', 'Vietnam', 4.6, 'ISO14001', '≤ 8 hrs', 1, 'Industrial equipment supplier focused on EU compliance.'],
            ['Lagos Textile Hub', 'Nigeria', 4.2, 'OEKO-TEX', '≤ 12 hrs', 0, 'Textile exporter specializing in custom dyeing and private labels.'],
        ];
        $supStmt = self::$connection->prepare('INSERT INTO suppliers (name, country, rating, certifications, response_time, verified, description) VALUES (?, ?, ?, ?, ?, ?, ?)');
        foreach ($suppliers as $supplier) {
            $supStmt->execute($supplier);
        }

        $products = [
            ['Smart Warehouse Scanner', 'smart-warehouse-scanner', 1, 1, 189.00, 'USD', 50, 'pcs', '15 days', 'FOB Shenzhen', 'China', 'Handheld scanner with RFID + QR support for 3PL warehouses.', 'Battery: 6200mAh; OS: Android 12; Connectivity: Wi-Fi 6'],
            ['Solar Garden Lighting Set', 'solar-garden-lighting-set', 3, 2, 6.40, 'USD', 200, 'sets', '20 days', 'FOB Hai Phong', 'Vietnam', 'Weather-resistant solar lighting for retail chains.', 'IP65; Battery: 2000mAh; Color temp: 3000K'],
            ['Organic Cotton Hotel Sheets', 'organic-cotton-hotel-sheets', 4, 3, 12.90, 'USD', 300, 'sets', '25 days', 'CIF Lagos', 'Nigeria', 'Luxury hotel bedding with custom embroidery options.', 'Thread count: 300; Size: King/Queen; Certification: OEKO-TEX'],
            ['AI Edge Inspection Camera', 'ai-edge-inspection-camera', 1, 1, 420.00, 'USD', 20, 'pcs', '30 days', 'FOB Shenzhen', 'China', 'AI-enabled camera for production line defect detection.', 'Resolution: 4K; AI model: YOLOv8; Interface: GigE'],
        ];
        $prodStmt = self::$connection->prepare('INSERT INTO products (name, slug, category_id, supplier_id, price, currency, min_order, moq_unit, lead_time, incoterms, origin, description, specs, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        foreach ($products as $product) {
            $prodStmt->execute([...$product, $now]);
        }

        $orderStmt = self::$connection->prepare('INSERT INTO orders (user_id, reference, status, total, currency, logistics, payment_terms, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $orderStmt->execute([1, 'PO-2024-GLB-1001', 'in_transit', 12890.00, 'USD', 'Sea Freight / CIF Shanghai', '30% T/T deposit, 70% before shipment', $now]);

        $itemStmt = self::$connection->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)');
        $itemStmt->execute([1, 1, 50, 189.00]);
        $itemStmt->execute([1, 2, 200, 6.40]);
    }
}
