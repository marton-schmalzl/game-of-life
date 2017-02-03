<?php

use GameOfLife\Action\HomeAction;
use GameOfLife\Action\EvolveAction;
use GameOfLife\Action\ListAction;
use GameOfLife\Action\LoadAction;

// Routes

$app->get('/', HomeAction::class)
    ->setName('homepage');

$app->get('/load', LoadAction::class)
    ->setName('load');
$app->get('/list', ListAction::class)
    ->setName('list');

$app->post('/evolve', EvolveAction::Class)
    ->setName('evolve');