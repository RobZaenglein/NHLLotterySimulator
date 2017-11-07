<?php

namespace App\Http\Controllers;

use App\Standings;

class HomeController extends Controller
{
    public function home()
    {
        $standings = new Standings();

        $lottery = $standings->determineLottery($standings->fromApi());

        dd($lottery);
    }
}