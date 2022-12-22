<?php

namespace Ramapriya\SlimPack\ExampleData\Services;

use Ramapriya\SlimPack\ExampleData\DTO\Http\ResponseDto;

class HelloService
{
    public function index()
    {
        return ResponseDto::create([
            'data' => [
                'message' => 'Hello, SlimPack works',
            ]
        ]);
    }
}
