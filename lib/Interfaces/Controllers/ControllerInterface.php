<?php

namespace Ramapriya\SlimPack\Interfaces\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramapriya\SlimPack\Interfaces\DTO\DTOInterface;

interface ControllerInterface
{
    public function parseRequestBody(ServerRequestInterface $request): array;

    public function prepareResponse(ResponseInterface $response, DTOInterface $dto): ResponseInterface;
}
