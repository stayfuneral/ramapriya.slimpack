<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\UrlRewriter;
use Ramapriya\SlimPack\Entities\RoutesTable;
use Ramapriya\SlimPack\Tools\Options;

Loc::loadMessages(__FILE__);

class ramapriya_slimpack extends CModule
{
    public $MODULE_ID = 'ramapriya.slimpack';

    private Connection $connection;

    private array $orms = [
        RoutesTable::class
    ];

    public function __construct()
    {
        $this->MODULE_NAME = 'Slim Framework';
        $this->MODULE_DESCRIPTION = Loc::getMessage('module_description');
        $this->PARTNER_NAME = Loc::getMessage('partner_name');
        $this->PARTNER_URI = 'https://github.com/stayfuneral';

        include __DIR__ . '/version.php';

        /**
         * @var array $arModuleVersion
         */
        if (!$arModuleVersion) {
            $arModuleVersion = [];
        }

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->connection = Application::getConnection();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);

        $this->InstallFiles();
        $this->installRoutes();
    }

    public function DoUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallFiles()
    {
        $slimApplicationPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim(Options::getSlimApplicationPath(), '/');
        $routesFilePath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim(dirname(Options::getRoutesFilePath()), '/');

        CopyDirFiles(__DIR__ . '/public', $slimApplicationPath, true, true);
        CopyDirFiles(__DIR__ . '/routes', $routesFilePath, true, true);
    }

    public function installRoutes(): void
    {
        UrlRewriter::add(SITE_ID, [
            'CONDITION' => Options::getSlimUrlRewriterCondition(),
            'PATH' => rtrim(Options::getSlimApplicationPath(), '/') . '/index.php'
        ]);
    }
}
