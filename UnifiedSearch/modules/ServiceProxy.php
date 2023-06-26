<?php

namespace UnifiedSearch\modules;

use GuzzleHttp\Psr7\Response;
use AmotiveTech\UnifiedSearch\Config;
use AmotiveTech\UnifiedSearch\Request;
use AmotiveTech\UnifiedSearch\USService;
use UnifiedSearch\controllers\Controller;

class ServiceProxy extends USService
{
    /**
     * @var Controller
     */
    private $controller;

    public function __construct(Config $config, Controller $controller)
    {
        parent::__construct($config);
        $this->controller = $controller;
    }

    protected function query(Request $request)
    {
        $this->controller->requestText[] = $request->getMethod() . ': ' . $this->config->getServiceUrl() . $this->getUrl($request);

        return parent::query($request);
    }

    protected function getResponseObject(Request $request, Response $response)
    {
        $responseObject = parent::getResponseObject($request, $response);
        $this->controller->responseText[] = (string)$response->getBody();
        return $responseObject;
    }

}