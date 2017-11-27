<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class Standings
{
    const DIVISION_PLAYOFFS_CUTOFF = 3;
    const NUM_WILDCARDS = 2;
    const CONFERENCES = ['Eastern', 'Western'];
    const CONFERENCE_EAST = 'Eastern';
    const CONFERENCE_WEST = 'Western';

    private $api = 'https://api.thescore.com/nhl/standings';

    /**
     * Takes standings 1-31 by points and returns the lottery
     *
     * @param Collection $standings
     * @return Collection
     */
    public static function determineLottery(Collection $standings)
    {
        $standings = $standings->all();

        foreach(self::CONFERENCES as $conference) {
            $potentialLottery[$conference] = array_filter($standings, function($team) use($conference) {
                return $team->conference == $conference && $team->division_ranking > self::DIVISION_PLAYOFFS_CUTOFF;
            });

            usort($potentialLottery[$conference], function($team1, $team2) {
                return $team1->points_percentage < $team2->points_percentage ? 1 : -1;
            });

            $potentialLottery[$conference] = array_slice($potentialLottery[$conference], self::NUM_WILDCARDS);
        }

        $lottery = array_merge($potentialLottery[self::CONFERENCE_WEST], $potentialLottery[self::CONFERENCE_EAST]);

        usort($lottery, function($team1, $team2) {
            if($team1->points_percentage == $team2->points_percentage) {
                return $team1->regulation_overtime_wins > $team2->regulation_overtime_wins ? 1 : -1;
            }
            return $team1->points_percentage > $team2->points_percentage ? 1 : -1;
        });

        return collect($lottery);
    }


    /**
     * Gives playoff teams ordered by points percentage ascending
     *
     * @param Collection $standings
     * @param \Illuminate\Support\Collection $lottery
     * @return Collection
     */
    public static function remainingStandings(Collection $standings, \Illuminate\Support\Collection $lottery)
    {
        return $standings->diff($lottery)->reverse();
    }

    /**
     * @return array
     */
    public function fromApi()
    {
        return json_decode(file_get_contents($this->api));
    }
}