<?php

use GameOfLife\Action\HomeAction;

// Routes

$app->get('/', HomeAction::class)
    ->setName('homepage');