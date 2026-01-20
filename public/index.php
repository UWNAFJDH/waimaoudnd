<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\InquiryController;
use App\Controllers\OrderController;
use App\Controllers\ProductController;
use App\Controllers\SupplierController;
use App\Router;

require dirname(__DIR__) . '/src/Database.php';
require dirname(__DIR__) . '/src/Router.php';
require dirname(__DIR__) . '/src/Controllers/Controller.php';
require dirname(__DIR__) . '/src/Controllers/HomeController.php';
require dirname(__DIR__) . '/src/Controllers/ProductController.php';
require dirname(__DIR__) . '/src/Controllers/SupplierController.php';
require dirname(__DIR__) . '/src/Controllers/InquiryController.php';
require dirname(__DIR__) . '/src/Controllers/OrderController.php';
require dirname(__DIR__) . '/src/Controllers/AuthController.php';
require dirname(__DIR__) . '/src/Controllers/AdminController.php';

session_start();

$router = new Router();
$home = new HomeController();
$product = new ProductController();
$supplier = new SupplierController();
$inquiry = new InquiryController();
$order = new OrderController();
$auth = new AuthController();
$admin = new AdminController();

$router->get('/', [$home, 'index']);
$router->get('/resources', [$home, 'resources']);
$router->get('/products', [$product, 'index']);
$router->get('/product', [$product, 'show']);
$router->get('/suppliers', [$supplier, 'index']);
$router->get('/supplier', [$supplier, 'show']);
$router->get('/inquiry', [$inquiry, 'form']);
$router->post('/inquiry', [$inquiry, 'submit']);
$router->get('/cart', [$order, 'cart']);
$router->post('/cart', [$order, 'addToCart']);
$router->get('/checkout', [$order, 'checkout']);
$router->get('/login', [$auth, 'loginForm']);
$router->post('/login', [$auth, 'login']);
$router->post('/logout', [$auth, 'logout']);
$router->get('/account', [$auth, 'account']);
$router->get('/admin', [$admin, 'dashboard']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
