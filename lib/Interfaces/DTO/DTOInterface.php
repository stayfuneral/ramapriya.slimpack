<?php

namespace Ramapriya\SlimPack\Interfaces\DTO;

interface DTOInterface
{
    public static function create(array $parameters): DTOInterface;

    public function prepareParameters(array &$parameters): void;
}
