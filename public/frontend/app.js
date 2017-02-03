'use strict';

// Declare app level module which depends on views, and components
angular.module('GameOfLife', [
  'ngRoute',
  'GameOfLife.game'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.otherwise({redirectTo: '/game'});
}]);
