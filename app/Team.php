<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'games_played',
        'points',
        'wins',
        'losses',
        'overtime_losses',
        'regulation_overtime_wins',
        'division_ranking',
        'points_percentage',
        'last_ten_record',
        'streak'
    ];

    public function gameTeam()
    {
        return $this->hasMany(GameTeam::class);
    }

    public function game()
    {
        return $this->belongsToMany(Game::class, 'game_teams', 'team_id', 'game_id');
    }

    public static function upcomingGames($teamId)
    {
        $teamGames = Team::where('id', $teamId)
            ->with(['game' => function($game) use($teamId) {
                $game->whereDate('game_date', '>=', (new \DateTime())->format('Y-m-d'));
                $game->orderBy('game_date', 'ASC');
                $game->limit(5);
                $game->with(['gameTeam' => function($gameTeam) use($teamId) {
                    $gameTeam->where('team_id', '!=', $teamId);
                    $gameTeam->with('team');
                }]);
            }])->first();

        return $teamGames;
    }

    public static function recentGames($teamId)
    {
        $teamGames = Team::where('id', $teamId)
            ->with(['game' => function($game) use($teamId) {
                $game->whereDate('game_date', '<=', (new \DateTime())->format('Y-m-d'));
                $game->orderBy('game_date', 'ASC');
                $game->limit(5);
                $game->with(['gameTeam' => function($gameTeam) use($teamId) {
                    $gameTeam->where('team_id', '!=', $teamId);
                    $gameTeam->with('team');
                }]);
            }])->first();

        return $teamGames;
    }

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
     * @return Team
     */
    public static function fromApiTeam(ApiTeam $apiTeam)
    {
        $team = new Team();
        
        $team->name = $apiTeam->full_name;
        $team->abbreviation = $apiTeam->abbreviation;
        $team->city = $apiTeam->city;
        $team->nickname = $apiTeam->nickname;
        $team->conference = $apiTeam->conference;
        $team->image_path = $apiTeam->image_path;
        $team->primary_color = $apiTeam->primary_color;
        $team->api_id = $apiTeam->api_id;
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

        return $team;
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
