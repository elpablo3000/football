<?php

namespace App\Http\Services;

use App\Models\Fixture;
use App\Models\Play;

class ResetService {
    public function resetFixturesAndPlays() {
        $this->resetPlays();
        $this->resetFixtures();
    }

    private function resetPlays() {
        Play::query()->delete();
    }

    private function resetFixtures() {
        Fixture::query()->delete();
    }
}
