<?php

require_once __DIR__.'/../utils/response.php';
class OrderController {
    private orderServices $service;

    public function __construct(orderServices $service) {

        $this->service = $service;
    }

    public function ListOrders() {
        response_json(200, $this->service->ListOrders());
    }

    public function createOrder($user_id, $status) {
        $orderId = $this->service->createOrder($user_id, $status);
        response_json(201, ['order_id' => $orderId, 'status' => $status]);
    }

    public function addItemToOrder($order_id, $instrument_id, $quantity) {
        $id = $this->service->addItemToOrder((int) $order_id, (int) $instrument_id, (int) $quantity);
        response_json(201, ['order_item_id' => $id]);
    }

    public function orderTotals($minTotal = null) {
        $threshold = isset($_GET['min_total']) ? (float) $_GET['min_total'] : null;
        response_json(200, $this->service->orderTotals($threshold));
    }
}