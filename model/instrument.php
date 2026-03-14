<?php
class Instrument {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM instruments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function increasePriceByFamily(int $familyId, float $percent): int {
        $factor = 1 + ($percent / 100);
        $stmt = $this->pdo->prepare("
            UPDATE instruments
            SET price = price * :factor
            WHERE family_id = :family_id AND is_active = 1
        ");
        $stmt->execute(['factor' => $factor, 'family_id' => $familyId]);
        return $stmt->rowCount();
    }

    public function setInactive(int $id): bool {
        $stmt = $this->pdo->prepare("
            UPDATE instruments
            SET is_active = 0
            WHERE id = :id
        ");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteInactive(): int {
        $stmt = $this->pdo->prepare("
            DELETE FROM instruments
            WHERE is_active = 0
        ");
        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * Per family: average instrument price, number of active products, total stock.
     */
    public function familyStats(): array {
        $stmt = $this->pdo->query("
            SELECT
                f.id AS family_id,
                f.name AS family_name,
                ROUND(AVG(i.price), 2) AS avg_price,
                SUM(CASE WHEN i.is_active = 1 THEN 1 ELSE 0 END) AS active_count,
                COALESCE(SUM(i.quantity), 0) AS total_stock
            FROM instrument_families f
            LEFT JOIN instruments i ON f.id = i.family_id
            GROUP BY f.id, f.name
            ORDER BY f.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function instrumentsByFamily(): array {
        $stmt = $this->pdo->query("
            SELECT
                i.id,
                i.name,
                f.name AS family_name,
                i.brand,
                i.price,
                IF(i.quantity > 0, 'In Stock', 'Out of Stock') AS stock_label
            FROM instruments i
            JOIN instrument_families f ON i.family_id = f.id
            ORDER BY f.name, i.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}