<?php

namespace Ramapriya\SlimPack\Tools;

use Bitrix\Main\Config\Option;
use Ramapriya\SlimPack\Interfaces\ModuleInterface;

class Options implements ModuleInterface
{
    private static function getOption(string $name): string
    {
        return Option::get(self::MODULE_ID, $name);
    }

    public static function getSlimApplicationPath(bool $raw = true): string
    {
        $path = self::getOption('slim_application_path');
        $prepared = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($path, '/');
        return  $raw ? $path : self::prepareAbsolutePath($path);
    }

    public static function getSlimUrlRewriterCondition(): string
    {
        return self::getOption('slim_urlrewriter_condition');
    }

    public static function getRoutesFilePath(bool $raw = true): string
    {
        $path = self::getOption('routes_file_path');
        return  $raw ? $path : self::prepareAbsolutePath($path);
    }

    public static function prepareAbsolutePath(string $path): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($path, '/');
    }
}
