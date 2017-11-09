<?php

namespace App;

class ApiTeam
{
    public $full_name;
    public $abbreviation;
    public $conference;
    public $api_id;
    public $games_played;
    public $points;
    public $wins;
    public $losses;
    public $overtime_losses;
    public $division_ranking;
    public $regulation_plus_overtime_wins;
    public $last_ten_games_record;
    public $streak;

    public function hydrateFromApi($team)
    {
        $this->full_name = $team->team->full_name;
        $this->abbreviation = $team->team->abbreviation;
        $this->conference = $team->conference;
        $this->api_id = $team->team->id;
        $this->games_played = $team->games_played;
        $this->points = $team->points;
        $this->wins = $team->wins;
        $this->losses = $team->losses;
        $this->overtime_losses = $team->overtime_losses;
        $this->division_ranking = $team->division_ranking;
        $this->regulation_plus_overtime_wins = $team->regulation_plus_overtime_wins;
        $this->last_ten_games_record = $team->last_ten_games_record;
        $this->streak = $team->streak;
    }
}