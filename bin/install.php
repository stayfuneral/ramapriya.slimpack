<?php

const NOT_CHECK_PERMISSIONS = true;
const NO_KEEP_STATISTIC     = true;
const NO_AGENT_CHECK        = true;

$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 4);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$module = CModule::CreateModuleObject('ramapriya.slimpack');
$module->DoInstall();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';


