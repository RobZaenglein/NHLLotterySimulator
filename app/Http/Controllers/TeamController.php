<?php

namespace App\Http\Controllers;

use App\Lottery;
use App\Standings;
use App\Team;

class TeamController
{
    public function team($abbr)
    {
        $standings = Team::orderBy('points_percentage', 'desc')->get();
        $lottery = Standings::determineLottery($standings);
        $team = Team::findByAbbreviation($abbr);
        $team->lottery_position = Lottery::teamPosition($lottery, $team);
        if($team->lottery_position) $team->lottery_odds = Lottery::ODDS[$team->lottery_position - 1];

        return view('team', [
            'team' => $team
        ]);
    }
}