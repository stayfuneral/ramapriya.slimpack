<?php

namespace Ramapriya\SlimPack\ExampleData\DTO\Http;

use Ramapriya\SlimPack\DTO\DTO;

class ResponseDto extends DTO
{
    public bool   $success = true;
    public ?array $data    = null;
    public array  $errors  = [];
}
