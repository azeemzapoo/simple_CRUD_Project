<?php

class orderServices {
    private Order $model;

    public function __construct(Order $model) { $this->model = $model; }

    public function ListOrders(): array {
        return $this->model->all();
    }

    public function createOrder(int $user_id, string $status): int {
        return $this->model->InsertNewOrder($user_id, $status);
    }

    /** unit_price is taken from instruments table at insert time. */
    public function addItemToOrder(int $order_id, int $instrument_id, int $quantity): int {
        return $this->model->addItem($order_id, $instrument_id, $quantity);
    }

    /** Per-order totals; optionally filter by minimum total amount. */
    public function orderTotals(?float $minTotal = null): array {
        return $this->model->orderTotals($minTotal);
    }
}