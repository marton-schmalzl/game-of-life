<?php

use GameOfLife\Action\HomeAction;
use GameOfLife\Action\EvolveAction;

// Routes

$app->get('/', HomeAction::class)
    ->setName('homepage');

$app->get('/evolve', EvolveAction::Class)
    ->setName('evolve');