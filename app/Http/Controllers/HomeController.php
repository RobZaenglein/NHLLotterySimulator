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
        $standings = Team::orderBy('points_percentage', 'DESC')->get();
        $lottery = Standings::determineLottery($standings);
        $remaining = Standings::remainingStandings($standings, $lottery);
        $todaysGames = Game::todaysGames();

        return view('home', [
            'lottery' => $lottery,
            'playoffs' => $remaining,
            'todaysGames' => $todaysGames,
            'odds' => Lottery::ODDS_PURE
        ]);

    }
}