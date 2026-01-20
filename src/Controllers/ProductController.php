<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class ProductController extends Controller
{
    public function index(): void
    {
        $db = Database::connection();
        $products = $db->query('SELECT products.*, categories.name AS category_name, suppliers.name AS supplier_name FROM products JOIN categories ON categories.id = products.category_id JOIN suppliers ON suppliers.id = products.supplier_id ORDER BY products.created_at DESC')->fetchAll();
        $categories = $db->query('SELECT * FROM categories')->fetchAll();

        $this->view('products/index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show(): void
    {
        $slug = $_GET['slug'] ?? '';
        $db = Database::connection();
        $stmt = $db->prepare('SELECT products.*, categories.name AS category_name, suppliers.name AS supplier_name, suppliers.country AS supplier_country, suppliers.rating AS supplier_rating, suppliers.certifications AS supplier_certifications, suppliers.response_time AS supplier_response_time, suppliers.description AS supplier_description, suppliers.id AS supplier_id FROM products JOIN categories ON categories.id = products.category_id JOIN suppliers ON suppliers.id = products.supplier_id WHERE products.slug = ?');
        $stmt->execute([$slug]);
        $product = $stmt->fetch();

        if (!$product) {
            http_response_code(404);
            $this->view('404');
            return;
        }

        $this->view('products/show', [
            'product' => $product,
        ]);
    }
}
