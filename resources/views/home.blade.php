@extends('layout')
@section('title', 'NHL Draft Odds')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>Standings</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Team</th>
                        <th class="text-center">Record</th>
                        <th class="text-center">Streak</th>
                        <th class="text-center">L10</th>
                        <th class="text-center">PP</th>
                        <th class="text-right">Odds</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lottery as $index => $team)
                    <tr>
                        <td class="text-left"><a href="/teams/{{strtolower($team->abbreviation)}}"><img src="{{$team->image_path}}" class="logo-small hidden-xs"> {{$team->name}}</a></td>
                        <td class="text-center">{{$team->wins}}-{{$team->losses}}-{{$team->overtime_losses}}</td>
                        <td class="text-center">{{$team->streak}}</td>
                        <td class="text-center">{{$team->last_ten_record}}</td>
                        <td class="text-center">{{$team->points_percentage * 100}}%</td>
                        <td class="text-right">{{$odds[$index]}}%</td>
                    </tr>
                    @endforeach
                    <tr class="separator"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    @foreach($playoffs as $team)
                        <tr class="eliminated">
                            <td><a href="/teams/{{strtolower($team->abbreviation)}}"><img src="{{$team->image_path}}" class="logo-small hidden-xs"> {{$team->name}}</a></td>
                            <td class="text-center">{{$team->wins}}-{{$team->losses}}-{{$team->overtime_losses}}</td>
                            <td class="text-center">{{$team->streak}}</td>
                            <td class="text-center">{{$team->last_ten_record}}</td>
                            <td class="text-center">{{$team->points_percentage * 100}}%</td>
                            <td class="text-right"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h2>Today's Games</h2>
            @forelse($todaysGames as $game)
                <div class="col-md-3">
                    <a href="/game/{{$game->id}}" class="game">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if($game->is_started)
                                    {{$game->clock_label}}
                                @else
                                    {{(new DateTime($game->game_date))->format('g:i a')}} est
                                @endif
                            </div>
                            <div class="panel-body">
                                @foreach($game->GameTeam as $gameTeam)
                                    <img src="{{$gameTeam->team->image_path}}" class="logo-small">
                                    {{$gameTeam->team->name}}
                                    <span class="pull-right">{{$gameTeam->score}}</span>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p>No games today.</p>
            @endforelse
        </div>
    </div>
@stop