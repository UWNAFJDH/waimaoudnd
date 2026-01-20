<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class InquiryController extends Controller
{
    public function form(): void
    {
        $productId = (int) ($_GET['product_id'] ?? 0);
        $db = Database::connection();
        $product = null;

        if ($productId) {
            $stmt = $db->prepare('SELECT * FROM products WHERE id = ?');
            $stmt->execute([$productId]);
            $product = $stmt->fetch();
        }

        $this->view('inquiries/form', ['product' => $product]);
    }

    public function submit(): void
    {
        $payload = [
            trim($_POST['name'] ?? ''),
            trim($_POST['email'] ?? ''),
            trim($_POST['company'] ?? ''),
            (int) ($_POST['product_id'] ?? 0) ?: null,
            (int) ($_POST['quantity'] ?? 0),
            $_POST['target_price'] !== '' ? (float) $_POST['target_price'] : null,
            trim($_POST['message'] ?? ''),
            date('c'),
        ];

        $db = Database::connection();
        $stmt = $db->prepare('INSERT INTO inquiries (name, email, company, product_id, quantity, target_price, message, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute($payload);

        $_SESSION['flash'] = '询盘已提交，供应商将在24小时内联系您。';
        header('Location: /inquiry');
    }
}
