<?php

namespace App\Http\Controllers;

use App\Game;
use App\Lottery;
use App\Standings;
use App\Team;

class HomeController extends Controller
{
    public function home()
    {
        $standings = Team::orderBy('points_percentage', 'desc')->get();
        $lottery = Standings::determineLottery($standings);
        $odds = Lottery::ODDS;
        $remaining = Standings::remainingStandings($standings, $lottery);
        $todaysGames = Game::todaysGames();

        return view('home', [
            'lottery' => $lottery,
            'odds' => $odds,
            'playoffs' => $remaining,
            'todaysGames' => $todaysGames
        ]);

    }
}