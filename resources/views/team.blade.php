@extends('layout')
@section('title', $team->name)
@section('content')
    <div class="row">
        <div class="col-xs-12 team" style="border-bottom: 3px solid #{{$team->primary_color}}">
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
            <ul class="team-info list-inline">
                <li>Record: <strong>{{$team->wins}}-{{$team->losses}}-{{$team->overtime_losses}}</strong></li>
                <li>Points %: <strong>{{$team->points_percentage * 100}}</strong></li>
                <li>Streak: <strong>{{$team->streak}}</strong></li>
                <li>Last 10: <strong>{{$team->last_ten_record}}</strong></li>
            </ul>
        </div>
        @if($team->lottery_position)
            <div class="col-xs-12 team-info">
                <div class="odds">
                    <h2>First Pick Odds</h2>
                    <h3>{{$team->lottery_odds}}%</h3>
                    <p>{{$team->city}} has the {{(new NumberFormatter('en_US', NumberFormatter::ORDINAL))->format($team->lottery_position)}} best odds at the first overall pick.</p>
                </div>
                <hr>
                <div class="games">
                    <h2>Upcoming Games</h2>
                </div>
            </div>
        @endif
    </div>
@stop