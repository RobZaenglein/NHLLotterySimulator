<?php
namespace App\Http\Controllers;

use App\Game;

class GameController extends Controller
{
    public function game($id)
    {
        $game = Game::where('id', $id)
            ->with(['GameTeam' => function($gameTeam) {
                return $gameTeam->with('Team');
            }])
            ->first();

        return view('game', [
            'game' => $game
        ]);
    }
}