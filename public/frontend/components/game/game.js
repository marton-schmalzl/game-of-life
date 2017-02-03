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
        self.evolve = function () {
            $http({
                method: 'GET',
                url: '/evolve',
                params: {cells: JSON.stringify(self.cells)}
            }).then(function successCallback(response) {
                self.cells = response.data.result;
                self.table = self.getTable(response.data.result)

            }, function errorCallback(response) {

            });
        };

        self.getTable = function (cells) {
            if (!cells[0]) return [];
            var tableForm = [];
            var minX = cells[0].x;
            var minY = cells[0].y;
            var maxX = cells[0].x;
            var maxY = cells[0].y;
            cells.forEach(function (cell) {
                if (minX > cell.x) minX = cell.x;
                if (minY > cell.y) minY = cell.y;
                if (maxX < cell.x) maxX = cell.x;
                if (maxY < cell.y) maxY = cell.y;
            });
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
                    tableForm[i][j] = {state: 0};
                }
            }
            cells.forEach(function (cell) {
                tableForm[cell.x + offsetX][cell.y + offsetY] = {state: 1, originalX: cell.x, originalY: cell.y};
            });
            return tableForm;

        };
        self.evolve();

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
