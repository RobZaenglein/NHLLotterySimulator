<?php

namespace App;

use DateTime;

class ApiGame
{
    const NOT_STARTED_STATUS = 'pre_game';

    public $api_event_id;
    public $game_date;
    public $is_started;
    public $clock;
    public $teams;

    public function hydrateFromApi($game)
    {
        $this->api_event_id = $game->id;
        $this->game_date = (new DateTime($game->game_date))->format('Y-m-d H:i:s');
        $this->is_started = $game->status !== self::NOT_STARTED_STATUS ? 1 : 0;
        $this->clock = is_object($game->box_score) ? $game->box_score->progress->clock : '0:00';
        $this->teams = [
            'home' => [
                'team' => Team::findByAbbreviation($game->home_team->abbreviation),
                'score' => is_object($game->box_score) ? $game->box_score->score->home->score : 0
            ],
            'away' => [
                'team' => Team::findByAbbreviation($game->away_team->abbreviation),
                'score' => is_object($game->box_score) ? $game->box_score->score->away->score : 0
            ]
        ];
    }
}