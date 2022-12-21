<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Ramapriya\SlimPack\Tools\Settings;

$request   = Context::getCurrent()->getRequest();
$module_id = ! empty(htmlspecialcharsbx($request->get('mid'))) ? $request->get('mid') : $request->get('id');

Loader::includeModule($module_id);

$settings = new Settings\Settings($request);
$settings->handleRequest();

$renderer = new Settings\Renderer($request);
$renderer->render();

