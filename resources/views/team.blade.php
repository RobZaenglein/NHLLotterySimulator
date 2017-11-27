@extends('layout')
@section('title', $team->name)
@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="team" style="border-bottom: 2px solid #{{$team->primary_color}}">
                <div class="heading">
                    <div>
                        <img src="{{$team->image_path}}" class="logo-lg">
                    </div>
                    <div class="team-name">
                        <h4>{{$team->city}}</h4>
                        <h2 style="color:#{{$team->primary_color}}">{{$team->nickname}}</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="team-stats">
                @if($team->lottery_position)
                    <div class="odds text-center">
                        <h4>First Pick Chance</h4>
                        <h2>{{$team->lottery_odds}}%</h2>
                        <em>{{$team->city}} has the {{(new NumberFormatter('en_US', NumberFormatter::ORDINAL))->format($team->lottery_position)}} best odds at the first overall pick.</em>
                    </div>
                @else
                    <div class="odds text-center">
                        <h4>First Pick Chance</h4>
                        <h2>Not In Lottery</h2>
                        <em>{{$team->city}} has no chance at the first overall pick.</em>
                    </div>
                @endif
                <hr>
                <ul>
                    <li>Record: <strong>{{$team->wins}}-{{$team->losses}}-{{$team->overtime_losses}}</strong></li>
                    <li>Points: <strong>{{$team->points}}</strong></li>
                    <li>Points %: <strong>{{$team->points_percentage * 100}}</strong></li>
                    <li>Streak: <strong>{{$team->streak}}</strong></li>
                    <li>Last 10: <strong>{{$team->last_ten_record}}</strong></li>
                </ul>
            </div>
            </ul>
        </div>
        <div class="col-md-6 col-xs-12 team-info">
            <div class="games">
                <h2>Upcoming Games</h2>
                @foreach($upcomingGames as $upcomingGame)
                    <a href="/game/{{$upcomingGame->id}}">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="game" style="border: 2px solid #{{$upcomingGame->gameTeam[0]->team->primary_color}}">
                                    <div class="col-xs-5 team-image"><img src="{{$upcomingGame->gameTeam[0]->team->image_path}}"></div>
                                    <div class="col-xs-7 game-info text-center">
                                            <h4>
                                                @if($upcomingGame->gameTeam[0]->location == 'home')
                                                    @
                                                @endif
                                                {{$upcomingGame->gameTeam[0]->team->nickname}}
                                                ({{$upcomingGame->gameTeam[0]->team->wins}}-{{$upcomingGame->gameTeam[0]->team->losses}}-{{$upcomingGame->gameTeam[0]->team->overtime_losses}})
                                            </h4>
                                        <div>{{(new DateTime($upcomingGame->game_date))->format('l, F jS g:i A')}} est</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop