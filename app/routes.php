<?php

use App\Action\HomeAction;
use App\Action\NotesAction;

// Routes

$app->get('/', HomeAction::class)
    ->setName('homepage');