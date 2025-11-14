<?php

use App\Http\Middleware\ForceJsonResponse;

class Kernel
{
    protected $middleware = [
        ForceJsonResponse::class,
    ];
}
