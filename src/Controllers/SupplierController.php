<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class SupplierController extends Controller
{
    public function index(): void
    {
        $db = Database::connection();
        $suppliers = $db->query('SELECT * FROM suppliers ORDER BY rating DESC')->fetchAll();
        $this->view('suppliers/index', ['suppliers' => $suppliers]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $db = Database::connection();
        $stmt = $db->prepare('SELECT * FROM suppliers WHERE id = ?');
        $stmt->execute([$id]);
        $supplier = $stmt->fetch();

        if (!$supplier) {
            http_response_code(404);
            $this->view('404');
            return;
        }

        $prodStmt = $db->prepare('SELECT * FROM products WHERE supplier_id = ?');
        $prodStmt->execute([$id]);
        $products = $prodStmt->fetchAll();

        $this->view('suppliers/show', [
            'supplier' => $supplier,
            'products' => $products,
        ]);
    }
}
