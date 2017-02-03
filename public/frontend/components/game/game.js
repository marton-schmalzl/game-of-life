'use strict';

angular.module('GameOfLife.game', ['ngRoute'])

    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/game/', {
            templateUrl: 'frontend/components/game/game.html',
            controller: 'gameCtrl'
        });
    }])

    .controller('gameCtrl', ['$scope', '$http', '$location', '$interval', function ($scope, $http, $location, $interval) {
        var self = this;
        self.cells = [
            {x: 0, y: 1},
            {x: 1, y: 2},
            {x: 2, y: 0},
            {x: 2, y: 1},
            {x: 2, y: 2}
        ];
        self.displayXmin = -15;
        self.displayYmin = -15;
        self.displayXmax = 15;
        self.displayYmax = 15;
        var table = [];
        self.offsetX = 0;
        self.offsetY = 0;
        var draw = function () {
          self.table = self.getTable(self.cells);
        };
        self.evolve = function () {
            $http({
                method: 'GET',
                url: '/evolve',
                params: {cells: JSON.stringify(self.cells)}
            }).then(function successCallback(response) {
                self.cells = response.data.result;
                draw();

            }, function errorCallback(response) {

            });
        };
        self.toggleCell = function (x, y) {
            var found = false;
            self.cells.forEach(function (cell, idx) {
                if (cell.x == x && cell.y == y){
                    var tempCells = self.cells;
                    self.cells = [];
                    tempCells.forEach(function (cell, idx2) {
                      if (idx2 == idx) return;
                      self.cells.push(cell);
                    });
                    found = true;
                }
            });
            if (!found){
                self.cells.push({x:x, y:y, state:1});
            }
            draw();
        };

        self.getHeader = function () {
            var indecies = [];
            var t = self.table.slice();
            var l = t.pop();
          for(var i = 0; i < l.length; i++){
              indecies.push(i- self.offsetY);
          }
          return indecies;
        };

        self.getTable = function (cells) {
            if (self.displayXmin < 0){
                self.offsetX = -self.displayXmin;
            }
            if (self.displayYmin < 0){
                self.offsetY = -self.displayYmin;
            }
            var tableForm = [];
            for (var i = self.displayXmin + self.offsetX; i <= self.displayXmax + self.offsetX; i++) {
                tableForm[i] = [];
                for (var j = self.displayYmin + self.offsetY; j <= self.displayYmax + self.offsetY; j++) {
                    tableForm[i][j] = {state: 0, originalX: i-self.offsetX, originalY: j-self.offsetY};
                }
            }
            cells.forEach(function (cell) {
                if(cell.x <= self.displayXmax && cell.y <= self.displayYmax && cell.x+ self.offsetX >= self.displayXmin && cell.y + self.offsetY>= self.displayYmin){
                    tableForm[cell.x + self.offsetX][cell.y + self.offsetY] = {state: 1, originalX: cell.x, originalY: cell.y};
                }
            });
            return tableForm;

        };
        self.table = self.getTable(self.cells);

        var run = false;
        self.interval = 1000;
        var poller = null;
        var start = function () {
            run = true;
            poller = $interval(function () {
                self.evolve();
            }, self.interval);
        };
        var stop = function () {
            run = false;
            $interval.cancel(poller);
            poller = undefined;
        };

        self.toggleRun = function () {
            if (run){
                stop();
            } else {
                start();
            }
        };
        $scope.$on("$destroy", function handler() {
            stop();
        });


    }]);
