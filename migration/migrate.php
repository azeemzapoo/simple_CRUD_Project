<?php
require_once __DIR__ . '/../config/database.php'; // sets $pdo

$sql = file_get_contents(__DIR__ . '/create_tables.sql');
if ($sql === false) {
    die('Cannot open SQL file');
}

try {
    $pdo->exec($sql);
    echo 'Migration success (PDO)';
} catch (PDOException $e) {
    echo 'Migration failed (PDO): ' . $e->getMessage();
}