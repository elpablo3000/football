<?php

namespace App\Http\Controllers;

use App\Http\Services\ResetService;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    public function index(Request $request, ResetService $resetService) {
        $resetService->resetFixturesAndPlays();
        return response()->json('success:success', 200);
    }
}
