<?php
namespace App\Http\Controllers;

use App\Lottery;
use App\Game;
use App\Standings;
use App\Team;

class GameController extends Controller
{
    public function game($id)
    {
        $standings = Team::orderBy('points_percentage', 'desc')->get();
        $lottery = Standings::determineLottery($standings);

        $game = Game::where('id', $id)
            ->with(['GameTeam' => function($gameTeam) {
                return $gameTeam->with('Team');
            }])
            ->first();

        foreach($game->GameTeam as &$gameTeam) {
            $position = Lottery::teamPosition($lottery, $gameTeam->Team);
            $gameTeam->Team->lottery_position = $position;
            if($position) $gameTeam->Team->lottery_odds = Lottery::ODDS[$position - 1];
        }

        return view('game', [
            'game' => $game
        ]);
    }
}