<?php

namespace Ramapriya\SlimPack\Tools\Settings;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Request;
use Bitrix\Main\UrlRewriter;
use Exception;
use Ramapriya\SlimPack\Interfaces\ModuleInterface;
use Ramapriya\SlimPack\Interfaces\Tools\Settings\SettingsInterface;
use Ramapriya\SlimPack\Tools\Options;

Loc::loadMessages(__FILE__);

class Settings implements ModuleInterface, SettingsInterface
{
    private ?Request $request = null;

    private array $excludedOptions = ['mid', 'lang', 'save', 'apply'];

    /**
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->setRequest($request);
    }

    /**
     * @param HttpRequest|Request|null $request
     */
    private function setRequest($request = null): void
    {
        $this->request = $request ?? Context::getCurrent()->getRequest();;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function handleRequest()
    {
        if ($this->request['save'] || $this->request['apply']) {
            foreach ($this->request->toArray() as $key => &$value) {
                if (in_array($key, $this->excludedOptions)) {
                    continue;
                }

                if (is_array($value)) {
                    $value = implode(',', $value);
                }

                if ($key === 'slim_urlrewriter_condition') {
                    UrlRewriter::update(SITE_ID, ['CONDITION' => Options::getSlimUrlRewriterCondition()], ['CONDITION' => $value]);
                } elseif ($key === 'slim_application_path') {
                    $this->changeSlimApplicationPath($value);
                    UrlRewriter::update(SITE_ID, ['PATH' => Options::getSlimApplicationPath() . '/index.php'], ['PATH' => $value . '/index.php']);
                }

                Option::set(self::MODULE_ID, $key, $value);
            }
        }
    }

    private function changeSlimApplicationPath(string $newPath)
    {
        $oldPath = Options::getSlimApplicationPath(false);
        $newPath = Options::prepareAbsolutePath($newPath);
        rename($oldPath, $newPath);
    }

}
