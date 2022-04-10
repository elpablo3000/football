<?php

namespace App\Http\Services;

use App\Models\Fixture;
use App\Models\Play;
use App\Models\Team;

class FixtureService {
    /**
     * Generate fixtures or get it from DB if they are alredy generated
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getFixtures() {
        $fixtures = $this->getFixturesFromDb();
        if ($fixtures->count() > 0) {
            return $fixtures;
        } else {
            //TODO: generation works wrong, fix it
            $this->generateFixtures();
            $fixtures = $this->getFixturesFromDb();
        }
        return $fixtures;
    }

    /**
     * Get fixtures from DB
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getFixturesFromDb() {
        return Fixture::query()->with('plays', 'plays.teamFirst', 'plays.teamSecond')->get();
    }

    /**
     * Generate the fixtures and save to DB
     */
    private function generateFixtures() {
        $teams = Team::query()->get();

        $halfMatrix = $this->generateTeamsHalfMatrix($teams);
        $gameCounter = 0;
        $currentFixture = null;
        foreach ($halfMatrix as $teamX => $setX) {
            foreach ($setX as $teamY => $setY) {
                //create new fixture every 2nd time
                if ($gameCounter%2 == 0) {
                    $currentFixture = new Fixture();
                    $currentFixture->week_number = ($gameCounter - $gameCounter%2) / 2 + 1;
                    $currentFixture->save();
                }
                $play = new Play();
                $play->team_first_id = $teamX;
                $play->team_second_id = $teamY;
                $play->fixture_id = $currentFixture->id;
                $play->save();

                $gameCounter++;
            }
        }
    }

    /**
     * Generate the team matrix to make fixtures
     *
     * @param $teams
     * @return array
     */
    private function generateTeamsHalfMatrix($teams) {
        //shuffle the ids of commands to make random combinations
        $teamsIds = $teams->pluck('id')->shuffle();
        $teamsMatrix = [];
        foreach ($teamsIds as $xKey => $xId) {
            foreach ($teamsIds as $yKey => $yId) {
                if ($xKey > $yKey)
                $teamsMatrix[$xId][$yId] = true;
            }
        }

        return $teamsMatrix;
    }
}
