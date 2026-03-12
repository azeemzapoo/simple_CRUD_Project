<?php
require_once __DIR__ . '/../config/database.php'; // $pdo

try {
    $pdo->beginTransaction();

    // adjust foreign key on order_items to cascade when instrument deleted
    $pdo->exec("
        ALTER TABLE order_items
        DROP FOREIGN KEY order_items_ibfk_2
    ");

    $pdo->exec("
        ALTER TABLE order_items
        ADD CONSTRAINT order_items_ibfk_2
        FOREIGN KEY (instrument_id)
        REFERENCES instruments(id)
        ON DELETE CASCADE
    ");

    $pdo->commit();
    echo "cascade FK applied\n";
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "migration error: " . $e->getMessage() . "\n";
}