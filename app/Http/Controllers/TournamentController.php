<?php

namespace App\Http\Controllers;

use App\Http\Services\TournamentService;

class TournamentController extends Controller
{
    public function index(TournamentService $tournamentService, $weekNumber) {
        return response()->json($tournamentService->getWeekSummaries($weekNumber));
    }
}
