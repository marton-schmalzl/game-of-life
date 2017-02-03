<?php

use GameOfLife\Action\EvolveAction;
use GameOfLife\Action\HomeAction;
use GameOfLife\Action\ListAction;
use GameOfLife\Action\LoadAction;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));

    return $logger;
};

// Database
$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['pdo'];

    return new PDO($settings['dsn'], $settings['username'], $settings['password']);
};

$container[GameOfLife\Action\HomeAction::class] = function ($c) {
    return new HomeAction($c->get('logger'));
};
$container[GameOfLife\Action\EvolveAction::class] = function ($c) {
    return new EvolveAction($c->get('logger'));
};

$container[GameOfLife\Action\LoadAction::class] = function ($c) {
    return new LoadAction($c->get('logger'));
};

$container[GameOfLife\Action\ListAction::class] = function ($c) {
    return new ListAction($c->get('logger'));
};

