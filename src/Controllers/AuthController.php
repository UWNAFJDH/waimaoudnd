<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;

final class AuthController extends Controller
{
    public function loginForm(): void
    {
        $this->view('account/login');
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $db = Database::connection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = '登录失败，请检查账号或密码。';
            header('Location: /login');
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        header('Location: /account');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }

    public function account(): void
    {
        $this->ensureLoggedIn();
        $db = Database::connection();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user']['id']]);
        $user = $stmt->fetch();

        $orderStmt = $db->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $orderStmt->execute([$user['id']]);
        $orders = $orderStmt->fetchAll();

        $this->view('account/dashboard', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    private function ensureLoggedIn(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}
