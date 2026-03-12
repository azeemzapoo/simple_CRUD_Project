<?php
function response_json(int $status, $data = null): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => $status,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}