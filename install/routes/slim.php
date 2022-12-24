<?php

use Ramapriya\SlimPack\ExampleData\Controllers\HelloController;
use Ramapriya\SlimPack\Middlewares\Http\JsonMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var App $app
 */

$app->group('/slim', function (RouteCollectorProxy $proxy) {
    $proxy->get('/hello', [HelloController::class, 'index'])->setName('hello');
});
