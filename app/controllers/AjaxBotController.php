<?php

namespace App\Controllers;

use Dico\Services\GlosbeWrapper;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

/**
 * Class HomeController
 * @package Sesterce\Controllers
 */
class AjaxBotController
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

    public function getRandWordDefinition(Request $request, Response $response, $args){
        $res = [];
        $word = $request->getParam('word');
        $definitions = GlosbeWrapper::getWordDefinitions($word);

        $definition = null;

        if(!empty($definitions['meanings'])){
            $maxIndex = count($definitions['meanings']) - 1;
            $randIndex = rand(0, $maxIndex);
            $definition = !empty($definitions['meanings'][$randIndex]['text']) ? $definitions['meanings'][$randIndex]['text'] : $definition;
        }

        if(!empty($definition)){
            $res = $definition;
        }
        echo json_encode($res);
    }
}
