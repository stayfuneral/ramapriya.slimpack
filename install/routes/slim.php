<?php

use Ramapriya\SlimPack\Controllers\HelloController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var App $app
 */

$app->group('/tst', function (RouteCollectorProxy $proxy) {
    $proxy->get('/hello', [HelloController::class, 'index'])->setName('hello');
});
