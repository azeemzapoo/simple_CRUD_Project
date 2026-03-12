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
}