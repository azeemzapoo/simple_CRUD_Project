<?php
class InstrumentService {
    private Instrument $model;
    public function __construct(Instrument $model) { $this->model = $model; }

    public function listInstruments(): array {
        return $this->model->all();
    }

    public function bumpFamilyPrice(int $familyId, float $percent): array {
        if ($percent <= 0) throw new InvalidArgumentException("percent must be > 0");
        $updated = $this->model->increasePriceByFamily($familyId, $percent);
        return ['updated' => $updated, 'family_id' => $familyId, 'percent' => $percent];
    }

    public function deactivateInstrument(int $id): array {
        $ok = $this->model->setInactive($id);
        if (!$ok) throw new RuntimeException("Failed to mark inactive", 500);
        return ['id' => $id, 'inactive' => true];
    }

    public function deleteInactiveInstruments(): array {
        $deleted = $this->model->deleteInactive();
        return ['deleted' => $deleted];
    }

    public function listInstrumentsByFamily(): array {
        return $this->model->instrumentsByFamily();
    }

    public function familyStats(): array {
        return $this->model->familyStats();
    }
}