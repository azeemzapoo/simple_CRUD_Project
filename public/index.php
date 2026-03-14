<?php
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Serve frontend dashboard at / or /dashboard.html
if (($path === '/' || $path === '/dashboard.html') && $method === 'GET') {
    header('Content-Type: text/html; charset=utf-8');
    readfile(__DIR__ . '/dashboard.html');
    exit;
}

require_once __DIR__ . '/../config/database.php';

// Route by path prefix so /orders* is handled by web_order.php
if (strpos($path, '/orders') === 0) {
    require_once __DIR__ . '/../routes/web_order.php';
} else {
    require_once __DIR__ . '/../routes/web.php';
}