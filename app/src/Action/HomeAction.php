<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class HomeAction.
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
        $this->logger->info('Home page action dispatched');

        $response = $response->withJson(array('message'=>'Hello, World!'));

        return $response;
    }
}
