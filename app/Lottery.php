<?php

namespace App;

use Illuminate\Support\Collection;

class Lottery
{
    const ODDS = [
        0 => 18,
        1 => 12.5,
        2 => 10.5,
        3 => 9.5,
        4 => 8.5,
        5 => 7.6,
        6 => 6.7,
        7 => 5.8,
        8 => 5.4,
        9 => 4.5,
        10 => 3.3,
        11 => 2.7,
        12 => 2.2,
        13 => 1.8,
        14 => 1
    ];

    const ODDS_PURE = [
        0 => 180,
        1 => 125,
        2 => 105,
        3 => 95,
        4 => 85,
        5 => 76,
        6 => 67,
        7 => 58,
        8 => 54,
        9 => 45,
        10 => 33,
        11 => 27,
        12 => 22,
        13 => 18,
        14 => 10
    ];

    /**
     * Gets the literal position in lottery for given team, false if not in lottery
     *
     * @param Collection $lottery
     * @param Team $team
     * @return bool|int
     */
    public static function teamPosition(Collection $lottery, Team $team)
    {
        foreach($lottery as $index => $lotteryTeam) {
            if($lotteryTeam->id === $team->id) {
                return $index + 1;
            }
        }

        return false;
    }
}