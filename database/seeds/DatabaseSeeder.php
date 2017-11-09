<?php

use Illuminate\Database\Seeder;
use App\Standings;
use App\ApiTeam;
use App\Team;
use App\Game;
use App\ApiGame;
use App\GameTeam;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->teams();
        $this->games();
    }

    public function teams()
    {
        $standings = new Standings();
        $teams = $standings->fromApi();
        usort($teams, function($team1, $team2) {
            return strcmp($team1->team->full_name, $team2->team->full_name);
        });

        foreach($teams as $newTeam) {
            $apiTeam = new ApiTeam();
            $apiTeam->hydrateFromApi($newTeam);
            $team = Team::fromApiTeam($apiTeam);
            $team->save();
        }
    }

    public function games()
    {
        $schedule = Game::scheduleFromApi();
        foreach($schedule->current_season as $day)
        {
            if($day->season_type !== 'regular') continue;
            $eventIds = $day->event_ids;
            $events = Game::eventsFromApi($eventIds);

            foreach($events as $event) {
                $apiGame = new ApiGame();
                $apiGame->hydrateFromApi($event);
                $game = Game::fromApiGame($apiGame);

                GameTeam::fromApiGame($game, $apiGame);
            }
        }
    }
}
