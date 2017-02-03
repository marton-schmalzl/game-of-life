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
            {x: 0, y: 0},
            {x: 0, y: 1},
            {x: 1, y: 1},
            {x: 1, y: 0},
            {x: 2, y: 2},
            {x: 2, y: 3},
            {x: 3, y: 2},
            {x: 3, y: 3}
        ];
        var table = [];
        var offsetX = 0;
        var offsetY = 0;
        var draw = function () {
            console.log(self.cells[0]);
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

        self.getTable = function (cells) {
            if (!cells.length) return [];
            var first = cells.pop();
            console.log(first);
            console.table(cells);
            var tableForm = [];
            var minX = first.x;
            var minY = first.y;
            var maxX = first.x;
            var maxY = first.y;
            cells.forEach(function (cell) {
                if (minX > cell.x) minX = cell.x;
                if (minY > cell.y) minY = cell.y;
                if (maxX < cell.x) maxX = cell.x;
                if (maxY < cell.y) maxY = cell.y;
            });
            cells.push(first);
            if (minX < 0) {
                offsetX = -1 * minX;
                minX += offsetX;
                maxX += offsetX;
            }
            if (minY < 0) {
                offsetY = -1 * minY;
                minY += offsetY;
                maxY += offsetY;
            }
            for (var i = minX; i <= maxX; i++) {
                tableForm[i] = [];
                for (var j = minY; j <= maxY; j++) {
                    tableForm[i][j] = {state: 0, originalX: i-offsetX, originalY: j-offsetY};
                }
            }
            cells.forEach(function (cell) {
                tableForm[cell.x + offsetX][cell.y + offsetY] = {state: 1, originalX: cell.x, originalY: cell.y};
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