<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const SCHEDULE_API = 'https://api.thescore.com/nhl/schedule';
    const EVENTS_API = 'https://api.thescore.com/nhl/events?id.in=';
    const SINGLE_EVENT_API = 'https://api.thescore.com/nhl/events/';

    protected $fillable = [
        'is_started',
        'clock',
        'clock_label',
        'period'
    ];

    public function gameTeam()
    {
        return $this->hasMany(GameTeam::class);
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, 'game_teams', 'game_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public static function todaysGames()
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('America/Los_Angeles'));

        return Game::whereDate('game_date', '=', $date->format('Y-m-d'))
            ->with(['GameTeam' => function($gameTeam) {
                $gameTeam->with('team');
            }])
            ->get();
    }

    public function updateFromApi()
    {
        $apiGame = new ApiGame();
        $apiGame->hydrateFromApi(json_decode(file_get_contents(self::SINGLE_EVENT_API . $this->api_event_id)));
        $this->update([
            'is_started' => $apiGame->is_started,
            'period' => $apiGame->period,
            'clock' => $apiGame->clock,
            'clock_label' => $apiGame->clock_label
        ]);

        foreach($this->GameTeam as $gameTeam) {
            $gameTeam->score = $apiGame->teams[$gameTeam->location]['score'];
            $gameTeam->save();
        }
    }

    /**
     * @param ApiGame $apiGame
     * @return Game
     */
    public static function fromApiGame(ApiGame $apiGame)
    {
        $game = new Game();
        date_default_timezone_set('UTC');
        $date = new \DateTime($apiGame->game_date);
        $date->setTimezone(new \DateTimeZone('America/New_York'));
        $game->api_event_id = $apiGame->api_event_id;
        $game->game_date = $date;
        $game->is_started = $apiGame->is_started;
        $game->period = $apiGame->period;
        $game->clock = $apiGame->clock;
        $game->clock_label = $apiGame->clock_label;
        $game->save();

        return $game;
    }

    /**
     * @return array
     */
    public static function scheduleFromApi()
    {
        return json_decode(file_get_contents(self::SCHEDULE_API));
    }

    /**
     * @param array $eventIds
     * @return array
     */
    public static function eventsFromApi($eventIds)
    {
        $uri = self::EVENTS_API . implode(',', $eventIds);

        return json_decode(file_get_contents($uri));
    }

}
