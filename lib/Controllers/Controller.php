<?php

namespace Ramapriya\SlimPack\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramapriya\SlimPack\Interfaces\Controllers\ControllerInterface;
use Ramapriya\SlimPack\Interfaces\DTO\DTOInterface;

abstract class Controller implements ControllerInterface
{
    public function parseRequestBody(ServerRequestInterface $request): array
    {
        return json_decode((string)$request->getBody(), true);
    }

    public function prepareResponse(ResponseInterface $response, DTOInterface $dto): ResponseInterface
    {
        $response->getBody()->write($dto->toString());
        return $response;
    }
}
