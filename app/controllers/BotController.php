<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

/**
 * Class HomeController
 * @package Sesterce\Controllers
 */
class BotController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * HomeController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function show(RequestInterface $request, ResponseInterface $response, $args){
        $this->container->view->render($response, 'pages/bot.twig', $args);
    }
}
