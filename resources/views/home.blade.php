@extends('layout')
@section('title', 'NHL Draft Odds')
@section('content')
    <div ng-app="lottery" ng-controller="indexController as c">
        <div class="row text-center buttons">
            <div class="col-xs-12">
                <button class="btn" ng-disabled="c.finished" ng-click="c.pickWinner()">Pick Winner</button>
                <button class="btn" ng-disabled="c.winners.length == 0" ng-click="c.reset()">Reset</button>
            </div>
        </div>
        <div class="row winners text-center" ng-show="c.winners.length">
            <div class="col-xs-12 col-md-6">
                <h2>Winners</h2>
                <div class="row">
                    <div class="winner col-xs-4" ng-repeat="team in c.winners">
                        <h4><%c.pickWords[$index]%></h4>
                        <img ng-src="<%team.image_path%>" alt="<%team.name%>" class="logo-large">
                        <h4><%team.name%></h4>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6" ng-show="c.finished">
                <h2>Draft Order</h2>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row row-table draft-order" ng-repeat="team in c.draftOrder track by $index" ng-if="$index < 7">
                            <%$index + 1%> <img ng-src="<%team.img%>" alt="<%team.name%>" class="logo-x-small">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="row row-table draft-order" ng-repeat="team in c.draftOrder track by $index" ng-if="$index > 6">
                            <%$index + 1%> <img ng-src="<%team.img%>" alt="<%team.name%>" class="logo-x-small">
                        </div>
                    </div>
                </div>
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
                            <td class="text-right">{{$team->lottery_odds}}%</td>
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
    </div>
    <script>
        window.lottery = {!! json_encode($lottery) !!};
        window.odds = {!! json_encode($odds) !!};
    </script>
    <script src="/js/jquery.js"></script>
    <script src="/js/angular.js"></script>
    <script src="/js/lodash.js"></script>
    <script src="/js/angular-animate.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/app.js?x={{rand(0,1000)}}"></script>
@stop