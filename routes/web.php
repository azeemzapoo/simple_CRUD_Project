<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/response.php';
require_once __DIR__ . '/../model/instrument.php';
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../services/InstrumentServices.php';
require_once __DIR__ . '/../controllers/InstrumentController.php';

$instrumentCtrl = new InstrumentController(
    new InstrumentService(new Instrument($pdo))
);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/users' && $method === 'GET') {
    response_json(200, (new User($pdo))->all());
} elseif ($path === '/instruments' && $method === 'GET') {
    $instrumentCtrl->index();
} elseif ($path === '/instruments/increase-price' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?? [];
    $instrumentCtrl->increasePrice($body['family_id'] ?? 0, $body['percent'] ?? 0);
} elseif ($path === '/instruments/deactivate' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?? [];
    $instrumentCtrl->deactivate($body['id'] ?? 0);
} elseif ($path === '/instruments/delete-inactive' && $method === 'DELETE') {
    $instrumentCtrl->deleteInactive();
} elseif ($path === '/instruments/by-family' && $method === 'GET') {
    $instrumentCtrl->listByFamily();
} elseif ($path === '/instruments/family-stats' && $method === 'GET') {
    $instrumentCtrl->familyStats();
} else {
    response_json(404, ['error' => 'Not found']);
}