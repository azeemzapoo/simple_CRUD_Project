<?php
require_once __DIR__.'/../utils/response.php';

class InstrumentController {
    public function __construct(private InstrumentService $service) {}

    public function index() {
        response_json(200, $this->service->listInstruments());
    }

    public function increasePrice($familyId, $percent) {
        response_json(200, $this->service->bumpFamilyPrice((int)$familyId, (float)$percent));
    }

    public function deactivate($id) {
        response_json(200, $this->service->deactivateInstrument((int)$id));
    }

    public function deleteInactive() {
        response_json(200, $this->service->deleteInactiveInstruments());
    }
}