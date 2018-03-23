<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

/**
 * Class HomeController
 * @package Sesterce\Controllers
 */
class HomeController
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
//        dump($args);
//        $bootstrapCSSFiles = getBootstrapCSSFiles();
//        $bootstrapJSFiles = getBootstrapJSFiles();
//
//        $args['cssFiles'] = $bootstrapCSSFiles;
//        $args['jsFiles'] = $bootstrapJSFiles;
        $this->container->view->render($response, 'pages/home.twig', $args);
    }
}
