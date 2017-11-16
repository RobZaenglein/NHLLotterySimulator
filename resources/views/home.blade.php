@extends('layout')
@section('title', 'NHL Draft Odds')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>Today's Games</h2>
            @foreach($todaysGames as $game)
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
            @endforeach
        </div>
    </div>
@stop