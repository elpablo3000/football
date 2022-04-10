<?php

namespace App\Http\Services;

use App\Models\Fixture;
use App\Models\FixtureResult;
use App\Models\Play;

class ResetService {
    /**
     * Reset all plays and fixtures
     */
    public function resetFixturesAndPlays() {
        $this->resetPlays();
        $this->resetFixtures();
        $this->resetFixturesResults();
    }

    /**
     * Reset plays
     */
    private function resetPlays() {
        Play::query()->delete();
    }

    /**
     * Reset fixtures
     */
    private function resetFixtures() {
        Fixture::query()->delete();
    }

    /**
     * Reset fixtures
     */
    private function resetFixturesResults() {
        FixtureResult::query()->delete();
    }
}
