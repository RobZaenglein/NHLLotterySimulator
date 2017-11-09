<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function gameTeam()
    {
        return $this->hasMany(GameTeam::class);
    }
}
