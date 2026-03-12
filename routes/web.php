<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__.'/../utils/response.php';
require_once __DIR__.'/../model/instrument.php';
require_once __DIR__.'/../services/InstrumentServices.php';
require_once __DIR__.'/../controllers/InstrumentController.php';

$instrumentCtrl = new InstrumentController(
    new InstrumentService(new Instrument($pdo))
);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/instruments' && $method === 'GET') {
    $instrumentCtrl->index();
} elseif ($path === '/instruments/increase-price' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $instrumentCtrl->increasePrice($body['family_id'], $body['percent']);
} elseif ($path === '/instruments/deactivate' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $instrumentCtrl->deactivate($body['id']);
} elseif ($path === '/instruments/delete-inactive' && $method === 'DELETE') {
    $instrumentCtrl->deleteInactive();
} else {
    response_json(404, ['error'=>'Not found']);
}