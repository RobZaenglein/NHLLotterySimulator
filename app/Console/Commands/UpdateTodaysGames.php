<?php

namespace App\Console\Commands;

use App\Game;
use Illuminate\Console\Command;

class UpdateTodaysGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateTodaysGames:updategames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets todays games then updates them minutely';

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
        foreach($todaysGames as $game) {
            if(!str_contains(strtolower($game->clock_label), 'final')) {
                $game->updateFromApi();
            }
        }
    }
}
