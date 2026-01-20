<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class HomeController extends Controller
{
    public function index(): void
    {
        $db = Database::connection();
        $categories = $db->query('SELECT * FROM categories')->fetchAll();
        $suppliers = $db->query('SELECT * FROM suppliers ORDER BY rating DESC LIMIT 3')->fetchAll();
        $products = $db->query('SELECT products.*, suppliers.name AS supplier_name FROM products JOIN suppliers ON suppliers.id = products.supplier_id ORDER BY products.created_at DESC LIMIT 4')->fetchAll();

        $this->view('home', [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'products' => $products,
        ]);
    }

    public function resources(): void
    {
        $this->view('resources');
    }
}
