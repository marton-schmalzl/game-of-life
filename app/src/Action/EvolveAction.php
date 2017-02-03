<?php

namespace GameOfLife\Action;

use GameOfLife\Game\Cell;
use GameOfLife\Game\Game;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Game EvolveAction.
 */
final class EvolveAction
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
        $rawCells = $request->getQueryParam('cells', []);
        $cells = [];
        foreach (json_decode($rawCells) as $rawCell){
            $cells[] = new Cell($rawCell->x, $rawCell->y);
        }
        $evolvedCells = Game::evolve($cells);
        $response = $response->withJson($evolvedCells);

        return $response;
    }
}
