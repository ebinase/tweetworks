<?php

namespace App\System;

use App\System\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    public function __construct(array $difinitions)
    {

    }

    public function resolve(string $path_info)
    {
        // TODO: Implement resolve() method.
    }
}