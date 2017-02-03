<?php

namespace GameOfLife\Action;

use GameOfLife\Game\Cell;
use GameOfLife\Game\Game;
use GameOfLife\Game\Parser;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Game LoadAction.
 */
class LoadAction
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
        $file = $request->getQueryParam('file', "pi.lif");
        $cells = Parser::read(PUBDIR ."/lif/" . $file);
        $response = $response->withJson($cells);

        return $response;
    }
}
