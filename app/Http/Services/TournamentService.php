<?php

namespace App\Http\Services;

use App\Http\Templates\TournamentResponse;
use App\Models\Fixture;
use App\Models\FixtureResult;
use App\Models\Play;
use App\Models\Team;

class TournamentService {
    private $fixtures;
    private $fixturesCount;
    private $isLast = false;
    private $maxDefaultGoals = 5;
    private $defaultGoals = 3;

    /**
     * Get summaries from selected week or generate them
     *
     * @param $week
     * @return TournamentResponse
     */
    public function getWeekSummaries($week) {
        $response = new TournamentResponse();
        $this->fixtures = $this->getFixturesForWeek($week + 1);

        if ($week == $this->fixturesCount) {
            $this->isLast = true;
        } else {
            $this->isLast = false;
        }

        $summaries = $this->getWeekSummariesFromDB($week);
        if ($summaries->count() < 1) {
            $this->generateWeekSummaries($week);
            $summaries = $this->getWeekSummariesFromDB($week);
        }

        $response->is_last = $this->isLast;
        $response->fixtures = $this->fixtures;
        $response->summaries = $summaries;

        return $response;
    }

    /**
     * Get summaries from db
     *
     * @param $week
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getWeekSummariesFromDB($week) {
        return FixtureResult::query()
            ->where('week_number', $week)
            ->with('team')
            ->get();
    }

    /**
     * Generate summaries for week
     *
     * @param $week
     */
    private function generateWeekSummaries($week) {
        if ($week == 0) {
            $this->generateZeroResults();
        } elseif ($this->isLast) {
            $this->generateWeekResults($week, true);
        } else {
            $this->playGames($week);
            $this->generateWeekResults($week);
        }
    }

    /**
     * Play the games for week
     *
     * @param $week
     */
    private function playGames($week) {
        if ($week != 0) {
            $currentFixture = Fixture::query()->where('week_number', $week)->first();

            foreach ($currentFixture->plays as $play) {
                if (!$play->played) {
                    $firstTeamGoalAvg = $this->getTeamGoalsAvg($play->team_first_id);
                    $secondTeamGoalAvg = $this->getTeamGoalsAvg($play->team_second_id);
                    $this->playGame($play, $firstTeamGoalAvg, $secondTeamGoalAvg);
                }
            }
        }
    }

    /**
     * Play the game based on previous average goals
     *
     * @param $play
     * @param $firstTeamGoalAvg
     * @param $secondTeamGoalAvg
     *
     * TODO: write separate logic if no games played by any of them
     */
    private function playGame($play, $firstTeamGoalAvg, $secondTeamGoalAvg) {
        $firstTeamGoalAvg = $firstTeamGoalAvg == 0 ? 1 : $firstTeamGoalAvg;
        $secondTeamGoalAvg = $secondTeamGoalAvg == 0 ? 1 : $secondTeamGoalAvg;
        $firstWon = false;

        $firstTeamWinChance = 100 * $firstTeamGoalAvg / ($firstTeamGoalAvg + $secondTeamGoalAvg);
        $firstTeamDiceRoll = mt_rand(1, 100);
        if ($firstTeamWinChance > $firstTeamDiceRoll) {
            $firstWon = true;
        }

        if ($firstWon) {
            $secondGoals = mt_rand(0, ((int)$firstTeamGoalAvg) - 1);
            $firstGoals = mt_rand($secondGoals, $this->maxDefaultGoals);
        } else {
            $firstGoals = mt_rand(0, ((int)$secondTeamGoalAvg) - 1);
            $secondGoals = mt_rand($firstGoals, $this->maxDefaultGoals);
        }

        $play->played = true;
        $play->team_first_result = $firstGoals;
        $play->team_second_result = $secondGoals;
        $play->save();
    }

    /**
     * Count the AVG amount of goals for selected team
     *
     * @param $teamId
     * @return float|int
     */
    private function getTeamGoalsAvg($teamId) {
        $goalsAvg = $this->defaultGoals;
        $results = [];

        $plays = Play::query()
            ->orWhere('team_first_id', $teamId)
            ->get();
        foreach ($plays as $play) {
            $results[] = $play->get('team_first_result');
        }

        $plays = Play::query()
            ->orWhere('team_second_id', $teamId)
            ->get();
        foreach ($plays as $play) {
            $results[] = $play->get('team_second_result');
        }

        if (count($results) > 0) {
            $goalsAvg = array_sum($results)/count($results);
        }

        return $goalsAvg;
    }

    /**
     * Generate summaries for 0 week
     */
    private function generateZeroResults() {
        $teams = Team::query()->orderBy('name')->get();
        foreach ($teams as $team) {
            $fixtureResult = new FixtureResult();
            $fixtureResult->team_id = $team->id;
            $fixtureResult->week_number = 0;
            $fixtureResult->played = 0;
            $fixtureResult->won = 0;
            $fixtureResult->drawn = 0;
            $fixtureResult->loosed = 0;
            $fixtureResult->goal_difference = 0;
            $fixtureResult->predictions = 0;
            $fixtureResult->save();
        }
    }

    /**
     * Generate summaries for selected week
     *
     * @param $week
     * @param false $final
     */
    private function generateWeekResults($week, $final = false) {
        $lastGeneratedResults = $this->getWeekSummaries($week - 1);
        foreach ($lastGeneratedResults->summaries as $summary) {
            $newSummary = new FixtureResult();
            $newSummary->team_id = $summary->team_id;
            $newSummary->week_number = $week;
            $newSummary->played = $this->getPlayedCountForTeam($summary->team_id);
            $newSummary->won = $this->getWonCountForTeam($summary->team_id);
            $newSummary->drawn = $this->getDrawnCountForTeam($summary->team_id);
            $newSummary->loosed = $this->getLoosedCountForTeam($summary->team_id);
            $newSummary->goal_difference = $this->getGDForTeam($summary->team_id);
            $newSummary->predictions = $final ? 0 : $this->getPredictionsForTeam($summary->team_id);

            $newSummary->save();
        }
    }

    /**
     * Get the amount of games played for selected team
     *
     * @param $teamId
     * @return int
     */
    private function getPlayedCountForTeam($teamId) {
        return Play::query()
            ->where('team_first_id', $teamId)
            ->orWhere('team_second_id', $teamId)
            ->having('played', true)
            ->get()
            ->count();
    }

    /**
     * Get the amount of games won for selected team
     *
     * @param $teamId
     * @return int
     */
    private function getWonCountForTeam($teamId) {
        $count = Play::query()
            ->where('team_first_id', $teamId)
            ->where('team_first_result', '>', 'team_second_result')
            ->get()
            ->count();
        $count += Play::query()
            ->where('team_second_id', $teamId)
            ->where('team_second_result', '>', 'team_first_result')
            ->get()
            ->count();

        return $count;
    }

    /**
     * Get the amount of games drawn for selected team
     *
     * @param $teamId
     * @return int
     */
    private function getDrawnCountForTeam($teamId) {
        $count = Play::query()
            ->where('team_first_id', $teamId)
            ->where('team_first_result', '=', 'team_second_result')
            ->having('played', true)
            ->get()
            ->count();
        $count += Play::query()
            ->where('team_second_id', $teamId)
            ->where('team_second_result', '=', 'team_first_result')
            ->having('played', true)
            ->get()
            ->count();

        return $count;
    }

    /**
     * Get the amount of games loosed for selected team
     *
     * @param $teamId
     * @return int
     */
    private function getLoosedCountForTeam($teamId) {
        $count = Play::query()
            ->where('team_first_id', $teamId)
            ->where('team_first_result', '<', 'team_second_result')
            ->get()
            ->count();
        $count += Play::query()
            ->where('team_second_id', $teamId)
            ->where('team_second_result', '<', 'team_first_result')
            ->get()
            ->count();

        return $count;
    }

    /**
     * Get the GD for selected team
     *
     * @param $teamId
     * @return mixed
     */
    private function getGDForTeam($teamId) {
        $count = Play::query()
            ->where('team_first_id', $teamId)
            ->get()
            ->sum('team_first_result');
        $count += Play::query()
            ->where('team_second_id', $teamId)
            ->get()
            ->sum('team_second_result');

        return $count;
    }

    /**
     * Count the chance of winning for selected team
     *
     * @param $teamId
     * @return int
     */
    private function getPredictionsForTeam($teamId) {
        //TODO: do some calculations for this parameter
        return 0;
    }

    /**
     * Get the list of fixtures for week and previous weeks
     *
     * @param $week
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getFixturesForWeek($week) {
        $fixtureService = new FixtureService();
        $fixtures = $fixtureService->getFixtures();
        $this->fixturesCount = $fixtures->count();

        return $fixtures->take($week);
    }
}
