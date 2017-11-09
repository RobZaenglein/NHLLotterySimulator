<?php

namespace App\Http\Controllers;

use App\ApiTeam;
use App\Standings;
use App\Team;

class HomeController extends Controller
{
    public function home()
    {
        $standings = Team::orderBy('points_percentage', 'desc')->get();
        $lottery = Standings::determineLottery($standings);
        $remaining = Standings::remainingStandings($standings, $lottery);
        dd($remaining);
    }
}