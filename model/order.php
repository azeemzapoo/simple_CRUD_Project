<?php

class Order {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function InsertNewOrder(int $user_id, string $status): int {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, status) VALUES (:user_id, :status)");
        $stmt->execute(['user_id' => $user_id, 'status' => $status]);
        return (int)$this->pdo->lastInsertId();
    }


    /**
     * Per-order totals: item count and total amount (sum of unit_price × quantity).
     * Optionally filter to orders whose total exceeds $minTotal.
     */
    public function orderTotals(?float $minTotal = null): array {
        $sql = "
            SELECT
                o.id AS order_id,
                o.user_id,
                o.order_date,
                o.status,
                COUNT(oi.id) AS item_count,
                COALESCE(SUM(oi.unit_price * oi.quantity), 0) AS total_amount
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            GROUP BY o.id, o.user_id, o.order_date, o.status
        ";
        if ($minTotal !== null && $minTotal > 0) {
            $sql .= " HAVING total_amount > :min_total";
        }
        $sql .= " ORDER BY o.id";
        $stmt = $this->pdo->prepare($sql);
        if ($minTotal !== null && $minTotal > 0) {
            $stmt->execute(['min_total' => $minTotal]);
        } else {
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** unit_price is always taken from instruments at insert time (not from client). */
    public function addItem(int $order_id, int $instrument_id, int $quantity): int {
        $priceStmt = $this->pdo->prepare("SELECT price FROM instruments WHERE id = :id AND is_active = 1");
        $priceStmt->execute(['id' => $instrument_id]);
        $row = $priceStmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new InvalidArgumentException("Instrument not found or inactive");
        }
        $unit_price = (float) $row['price'];
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, instrument_id, unit_price, quantity) VALUES (:order_id, :instrument_id, :unit_price, :quantity)");
        $stmt->execute([
            'order_id' => $order_id,
            'instrument_id' => $instrument_id,
            'unit_price' => $unit_price,
            'quantity' => $quantity
        ]);
        return (int) $this->pdo->lastInsertId();
    }





}

