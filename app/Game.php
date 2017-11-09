<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const SCHEDULE_API = 'https://api.thescore.com/nhl/schedule';
    const EVENTS_API = 'https://api.thescore.com/nhl/events?id.in=';

    public function gameTeam()
    {
        return $this->hasMany(GameTeam::class);
    }

    /**
     * @param ApiGame $apiGame
     * @return Game
     */
    public static function fromApiGame(ApiGame $apiGame)
    {
        $game = new Game();
        $game->api_event_id = $apiGame->api_event_id;
        $game->game_date = $apiGame->game_date;
        $game->is_started = $apiGame->is_started;
        $game->clock = $apiGame->clock;
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
