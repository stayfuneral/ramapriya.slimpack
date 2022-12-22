<?php

namespace Ramapriya\SlimPack\ExampleData\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramapriya\SlimPack\Controllers\Controller;
use Ramapriya\SlimPack\ExampleData\Services\HelloService;

class HelloController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $service = new HelloService();
        return $this->prepareResponse($response, $service->index());
    }
}
