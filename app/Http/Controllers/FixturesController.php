<?php

namespace App\Http\Controllers;

use App\Http\Services\FixtureService;
use App\Models\Team;

class FixturesController extends Controller
{
    public function index(FixtureService $fixtureService) {
        return $fixtureService->getFixtures();
    }
}
