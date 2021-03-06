@extends('layout')
@section('title', 'NHL Game Recap')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-center game-date">
                @if($game->is_started)
                    {{$game->clock_label}}
                @else
                    {{(new DateTime($game->game_date))->format('l, F jS')}}<br>
                    {{(new DateTime($game->game_date))->format('g:i A')}}
                @endif
            </h3>
            <div class="row">
                @foreach($game->GameTeam as $team)
                    <div class="col-xs-6 game-box"  style="border-bottom: 3px solid #{{$team->team->primary_color}}">
                        <div class="heading">
                            <div>
                                <a href="/teams/{{strtolower($team->team->abbreviation)}}"><img src="{{$team->team->image_path}}" class="logo-md"></a>
                            </div>
                            <div class="team-name">
                                <h4>{{$team->team->city}}</h4>
                                <h2 style="color:#{{$team->team->primary_color}}">{{$team->team->nickname}}</h2>
                            </div>
                            <div class="pull-right score"><h1>{{$team->score}}</h1></div>
                        </div>
                    </div>
                @endforeach
                @foreach($game->GameTeam as $team)
                    <div class="col-xs-6 team-stats">
                        <ul>
                            <li>Record: <strong>{{$team->team->wins}}-{{$team->team->losses}}-{{$team->team->overtime_losses}}</strong></li>
                            <li>Points: <strong>{{$team->team->points}}</strong></li>
                            <li>Points %: <strong>{{$team->team->points_percentage * 100}}</strong></li>
                            <li>Streak: <strong>{{$team->team->streak}}</strong></li>
                            <li>Last 10: <strong>{{$team->team->last_ten_record}}</strong></li>
                            <li>
                                Lottery Position:
                                <strong>
                                    @if($team->Team->lottery_position)
                                        {{$team->Team->lottery_position}} ({{$team->Team->lottery_odds}}%)
                                    @else
                                        Out of Lottery
                                    @endif
                                </strong>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop