<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * @param ApiTeam $apiTeam
     */
    public function updateStatistics(ApiTeam $apiTeam)
    {
        $this->games_played = $apiTeam->games_played;
        $this->points = $apiTeam->points;
        $this->wins = $apiTeam->wins;
        $this->losses = $apiTeam->losses;
        $this->overtime_losses = $apiTeam->overtime_losses;
        $this->regulation_overtime_wins = $apiTeam->regulation_plus_overtime_wins;
        $this->division_ranking = $apiTeam->division_ranking;
        $this->points_percentage = round($apiTeam->points / ($apiTeam->games_played * 2), 3);
        $this->last_ten_record = $apiTeam->last_ten_games_record;
        $this->streak = $apiTeam->streak;

        $this->save();
    }

    /**
     * @param ApiTeam $apiTeam
     */
    public static function fromApiTeam(ApiTeam $apiTeam)
    {
        $team = new Team();
        
        $team->full_name = $apiTeam->team->full_name;
        $team->abbreviation = $apiTeam->team->abbreviation;
        $team->conference = $apiTeam->conference;
        $team->games_played = $apiTeam->games_played;
        $team->points = $apiTeam->points;
        $team->wins = $apiTeam->wins;
        $team->losses = $apiTeam->losses;
        $team->overtime_losses = $apiTeam->overtime_losses;
        $team->regulation_overtime_wins = $apiTeam->regulation_plus_overtime_wins;
        $team->division_ranking = $apiTeam->division_ranking;
        $team->points_percentage = round($apiTeam->points / ($apiTeam->games_played * 2), 3);
        $team->last_ten_record = $apiTeam->last_ten_games_record;
        $team->streak = $apiTeam->streak;

        $team->save();
    }

    /**
     * @param $abbreviation
     * @return Team
     */
    public static function findByAbbreviation($abbreviation)
    {
        return Team::where('abbreviation', $abbreviation)->first();
    }
}
