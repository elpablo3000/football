<?php

namespace App\Http\Controllers;

use App\Http\Services\FixtureService;

class FixturesController extends Controller
{
    public function index(FixtureService $fixtureService) {
        return $fixtureService->getFixtures();
    }
}
