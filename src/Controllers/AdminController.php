<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->ensureAdmin();
        $db = Database::connection();

        $metrics = [
            'users' => (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'suppliers' => (int) $db->query('SELECT COUNT(*) FROM suppliers')->fetchColumn(),
            'products' => (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn(),
            'inquiries' => (int) $db->query('SELECT COUNT(*) FROM inquiries')->fetchColumn(),
        ];

        $inquiries = $db->query('SELECT inquiries.*, products.name AS product_name FROM inquiries LEFT JOIN products ON products.id = inquiries.product_id ORDER BY created_at DESC LIMIT 6')->fetchAll();

        $this->view('admin/dashboard', [
            'metrics' => $metrics,
            'inquiries' => $inquiries,
        ]);
    }

    private function ensureAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }
}
