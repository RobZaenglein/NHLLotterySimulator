<?php

namespace App\Http\Controllers;

use App\ApiGame;
use App\ApiTeam;
use App\Game;
use App\GameTeam;
use App\Standings;
use App\Team;

class HomeController extends Controller
{
    public function home()
    {
        $standings = Team::orderBy('points_percentage', 'desc')->get();
        $lottery = Standings::determineLottery($standings);
        $remaining = Standings::remainingStandings($standings, $lottery);
        $todaysGames = Game::todaysGames();

        return view('home', [
            'lottery' => $lottery,
            'playoffs' => $remaining,
            'todaysGames' => $todaysGames
        ]);

    }
}