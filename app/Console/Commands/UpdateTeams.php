<?php

namespace App\Console\Commands;

use App\ApiTeam;
use App\Game;
use App\Standings;
use App\Team;
use Illuminate\Console\Command;

class UpdateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all teams from the API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $todaysGames = Game::todaysGames();
        $run = false;
        foreach($todaysGames as $game) {
            if(str_contains(strtolower($game->clock_label), 'final')) {
                $run = true;
            }
        }

        if(!$run) exit;

        $standings = new Standings();
        $teams = $standings->fromApi();
        usort($teams, function($team1, $team2) {
            return strcmp($team1->team->full_name, $team2->team->full_name);
        });

        foreach($teams as $newTeam) {
            $apiTeam = new ApiTeam();
            $apiTeam->hydrateFromApi($newTeam);
            $team = Team::findByAbbreviation($apiTeam->abbreviation);

            $team->update([
                'games_played' => $apiTeam->games_played,
                'points' => $apiTeam->points,
                'wins' => $apiTeam->wins,
                'losses' => $apiTeam->losses,
                'overtime_losses' => $apiTeam->overtime_losses,
                'regulation_overtime_wins' => $apiTeam->regulation_plus_overtime_wins,
                'division_ranking' => $apiTeam->division_ranking,
                'points_percentage' => round($apiTeam->points / ($apiTeam->games_played * 2), 3),
                'last_ten_record' => $apiTeam->last_ten_games_record,
                'streak' => $apiTeam->streak
            ]);
        }
    }
}
