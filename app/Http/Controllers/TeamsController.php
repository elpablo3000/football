<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamsController extends Controller
{
    public function index() {
        return Team::query()->orderBy('name')->get();
    }
}
