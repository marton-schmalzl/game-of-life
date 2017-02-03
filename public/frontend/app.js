'use strict';

// Declare app level module which depends on views, and components
angular.module('GameOfLife', [
  'ngRoute',
  'ngSanitize',
  'GameOfLife.game',
  'ngAnimate',
  'ui.bootstrap',
  'ui.toggle'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.otherwise({redirectTo: '/game'});
}]);
