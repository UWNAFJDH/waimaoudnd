<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class OrderController extends Controller
{
    public function cart(): void
    {
        $items = $_SESSION['cart'] ?? [];
        $db = Database::connection();
        $cartItems = [];
        $total = 0.0;

        foreach ($items as $productId => $quantity) {
            $stmt = $db->prepare('SELECT * FROM products WHERE id = ?');
            $stmt->execute([$productId]);
            $product = $stmt->fetch();
            if (!$product) {
                continue;
            }
            $subtotal = $quantity * (float) $product['price'];
            $total += $subtotal;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        $this->view('orders/cart', [
            'items' => $cartItems,
            'total' => $total,
        ]);
    }

    public function addToCart(): void
    {
        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

        if ($productId) {
            $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
        }

        header('Location: /cart');
    }

    public function checkout(): void
    {
        $this->view('orders/checkout');
    }
}
