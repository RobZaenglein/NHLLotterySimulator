<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameTeam extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public static function fromApiGame(Game $game, ApiGame $apiGame)
    {
        foreach($apiGame->teams as $location => $team) {
            $gameTeam = new GameTeam();
            $gameTeam->game_id = $game->id;
            $gameTeam->team_id = $team['team']->id;
            $gameTeam->location = $location;
            $gameTeam->score = $team['score'];
            $gameTeam->save();
        }
    }
}
