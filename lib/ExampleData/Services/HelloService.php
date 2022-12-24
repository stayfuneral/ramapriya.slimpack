<?php

namespace Ramapriya\SlimPack\ExampleData\Services;

use Exception;
use Ramapriya\SlimPack\ExampleData\DTO\Http\ResponseDto;
use Spatie\DataTransferObject\DataTransferObject;

class HelloService
{
    private bool $enableException = true;

    /**
     * @return DataTransferObject
     * @throws Exception
     */
    public function index(): DataTransferObject
    {
        if ($this->enableException) {
            throw new Exception(
                'Exception enabled'
            );
        }

        return ResponseDto::create([
            'data' => [
                'message' => 'Hello, SlimPack works',
            ]
        ]);
    }
}
