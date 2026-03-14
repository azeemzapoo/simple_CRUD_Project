<?php

class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT id, full_name, email, created_at FROM users ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
