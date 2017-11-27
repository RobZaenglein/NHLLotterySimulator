'use strict';

var lotto = angular.module('lottery', []).controller('indexController', ['$http', function (http) {
    var vm = this;

    // simple function to create copies of objects and arrays
    var clone = function(a) {
        return JSON.parse(JSON.stringify(a));
    };
    vm.standings = window.lottery;
    vm.results = [];
    vm.runs = 0;
    vm.sortType = "first";

    // the current odds for the lottery (chances out of 1000)
    var odds;
    vm.odds = odds = window.odds;

    vm.pickWords = ['First', 'Second', 'Third'];

    // function to be called before starting a lottery to ensnure all data is reset
    vm.reset = function() {
        // create copies of variables that will change to preserve original data
        vm.totalEntries = 990;

        // reset variables that are created during the process to blank
        vm.draftOrder = [];
        vm.winners = [];
        vm.currentPick = vm.pickWords[0];
        vm.finished = false;

        // run functions to fill data
        vm.pool = clone(vm.standings);
        _.each(vm.pool, function(team) {
            team.totalPercentage = 0;
        });
        vm.getOdds();
        vm.createWinningNumbers();
    };

    vm.getOdds = function() {
        //assign a numeric odds and percentage of winning for each team left in the pool
        _.each(vm.pool, function(team, n) {
            team.odds = vm.odds[team.index];
            var percentage = Number((100 * (vm.odds[team.index] / vm.totalEntries)).toFixed(3));
            team.percentage = percentage;
            team.totalPercentage = Number((team.totalPercentage + percentage).toFixed(3))
        });
    };

    vm.createWinningNumbers = function() {
        // this function is responsible for creating an array of 1000 and assigning a winning team to each index
        vm.lottery = [];
        var start = 0;
        for(var x=0; x<16; x++) {
            for(var i=start; i<odds[x] + start; i++) {
                vm.lottery[i] = x;
            }
            start += odds[x];
        }
    }

    vm.pickWinner = function() {

        // sanity checks
        if (vm.winners.length > 3) {
            return;
        }

        var winner = vm.lottery[Math.floor(Math.random() * (vm.totalEntries - 1))];

        // add the winner to the winners array and push to draft order
        vm.winners.push(vm.standings[winner]);
        vm.draftOrder.push(vm.standings[winner]);

        // now we need to remove all of this team's occurrences from the lottery so they don't win again
        vm.lottery = _.filter(vm.lottery, function(n) {
            return n != winner;
        });

        // now we must subtract the total number of entries the winner had from the total odds
        vm.totalEntries -= vm.odds[vm.standings[winner].index];

        // now remove the winner from the pool of possible winners
        vm.pool = _.filter(vm.pool, function(n){
            return n.index != vm.standings[winner].index;
        });

        // finally, either we are finished picking winners, or we recalculate the odds for the next pick
        if(vm.winners.length < 3) {
            vm.getOdds();
            vm.currentPick = vm.pickWords[vm.winners.length];
        }
        else {
            // we're done the lotto so put the remaining teams in order to the draft order
            vm.finished = true;
            _.each(vm.pool, function(team) {
                vm.draftOrder.push(team);
            });
            vm.runs += 1;

            // add the results to the results and calculate the percentages
            vm.calculateResults();

            // sort the total by the sort type
            vm.sortResults(vm.sortType);
        }
    }

    vm.calculateResults = function() {
        _.each(vm.winners, function(winner, n) {
            var index = _.findIndex(vm.results, function(t) { return t.name == winner.name; });
            if(index >= 0) {
                var team = vm.results[index];
                switch(n) {
                    case 0:
                        team.first += 1;
                        break;
                    case 1:
                        team.second += 1;
                        break;
                    case 2:
                        team.third += 1;
                        break;
                };
                team.topthree += 1;
            }
            else {
                var team = {
                    name: winner.name,
                    first: 0,
                    second: 0,
                    third: 0,
                    topthree: 0,
                }
                var img = team.name.replace(/ /g,'-').toLowerCase();
                team.img = "/images/logos/" + img + ".png";
                switch(n) {
                    case 0:
                        team.first += 1;
                        break;
                    case 1:
                        team.second += 1;
                        break;
                    case 2:
                        team.third += 1;
                        break;
                };
                team.topthree += 1;
                vm.results.push(team);
            }
        });
    }

    vm.sortResults = function(type) {
        vm.sortType = type;
        switch(type) {
            case "first":
                vm.results.sort(function(a, b) {return b.first - a.first || b.second - a.second || b.third - a.third || b.topthree - a.topthree});
                break;
            case "second":
                vm.results.sort(function(a, b) {return b.second - a.second || b.first - a.first || b.third - a.third || b.topthree - a.topthree;});
                break;
            case "third":
                vm.results.sort(function(a, b) {return b.third - a.third || b.first - a.first || b.second - a.second || b.topthree - a.topthree;});
                break;
            case "topthree":
                vm.results.sort(function(a, b) {return b.topthree - a.topthree || b.first - a.first || b.second - a.second || b.third - a.third;});
                break;
        }
    }

    $('li a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    vm.reset();
}]);
lotto.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});