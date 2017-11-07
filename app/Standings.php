<?php

namespace App;

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
     * @param array $standings
     * @return array
     */
    public function determineLottery(array $standings)
    {
        foreach ($standings as &$team) {
            $team->points_percentage = $team->points / ($team->games_played * 2);
        }

        foreach(self::CONFERENCES as $conference) {
            $potentialLottery[$conference] = array_filter($standings, function($team) use ($conference) {
                return $team->conference == $conference && $team->division_ranking > self::DIVISION_PLAYOFFS_CUTOFF;
            });

            usort($potentialLottery[$conference], function($team1, $team2) {
                return $team1->points_percentage < $team2->points_percentage ? 1 : -1;
            });

            $potentialLottery[$conference] = array_slice($potentialLottery[$conference], self::NUM_WILDCARDS);
        }

        $lottery = array_merge($potentialLottery[self::CONFERENCE_EAST], $potentialLottery[self::CONFERENCE_WEST]);

        usort($lottery, function($team1, $team2) {
            return $team1->points_percentage > $team2->points_percentage ? 1 : -1;
        });

        return $lottery;
    }

    /**
     * @return array
     */
    public function fromApi()
    {
        return json_decode(file_get_contents($this->api));
    }
}