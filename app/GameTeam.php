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
}
