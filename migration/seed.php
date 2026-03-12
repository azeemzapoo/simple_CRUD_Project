<?php
require_once __DIR__ . '/../config/database.php'; // $pdo or $conn
$sql = file_get_contents(__DIR__ . '/seed_data.sql');
if ($sql === false) die('seed file missing');

try {
    $pdo->exec($sql);
    echo "Seed completed.\n";
} catch (PDOException $e) {
    echo "Seed failed: " . $e->getMessage() . "\n";
}