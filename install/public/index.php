<?php

use Bitrix\Main\Loader;
use Ramapriya\SlimPack\Tools\Options;
use Slim\Factory\AppFactory;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

Loader::includeModule('ramapriya.slimpack');

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

require_once Options::getRoutesFilePath(false);

$app->run();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
