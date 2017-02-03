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
class ListAction
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
        $dir = PUBDIR ."/lif/";
        $files = [];
        $iterator = new \DirectoryIterator($dir);
        $fileIterator = new \RegexIterator($iterator, "/.\\.lif/");
        foreach ($fileIterator as $name => $file){
            $files[] = $file->getFilename();
        }
        $response = $response->withJson($files);

        return $response;
    }
}
