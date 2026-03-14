<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__.'/../utils/response.php';
require_once __DIR__.'/../model/order.php';
require_once __DIR__.'/../services/OrderServices.php';
require_once __DIR__.'/../controllers/OrderController.php';


$orderCtrl = new OrderController(
    new orderServices(new order($pdo))
);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);   

if ($path === '/orders' && $method === 'GET') {
    $orderCtrl->ListOrders();
} elseif ($path === '/orders/totals' && $method === 'GET') {
    $orderCtrl->orderTotals();
} elseif ($path === '/orders/create' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?? [];
    $user_id = (int) ($body['user_id'] ?? 0);
    $orderCtrl->createOrder($user_id, 'PENDING');
} elseif ($path === '/orders/add-item' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?? [];
    $orderCtrl->addItemToOrder($body['order_id'] ?? 0, $body['instrument_id'] ?? 0, $body['quantity'] ?? 0);
}
else {
    response_json(404, ['error'=>'Not found']);
}
