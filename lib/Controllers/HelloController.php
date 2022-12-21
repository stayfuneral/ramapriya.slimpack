<?php

namespace Ramapriya\SlimPack\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write('Hello, SlimPack works!');
        return $response;
    }
}
