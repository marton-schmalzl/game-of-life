<?php

namespace GameOfLife\Action;

use GameOfLife\Game\Cell;
use GameOfLife\Game\Game;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Game HomeAction.
 */
final class HomeAction
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function __invoke(Request $request, Response $response, $args)
    {
        $cells = [
            new Cell(0,0),
            new Cell(0,1),
            new Cell(0,2),
        ];
        $evolvedCells = Game::evolve($cells);
        $response = $response->withJson($evolvedCells);

        //$response = $response->withJson(array('message'=>'Hello, World!'));

        return $response;
    }
}
