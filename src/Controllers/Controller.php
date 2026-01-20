<?php

declare(strict_types=1);

namespace App\Controllers;

final class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require dirname(__DIR__) . '/Views/' . $template . '.php';
    }
}
