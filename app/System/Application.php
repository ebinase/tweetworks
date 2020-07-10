<?php

namespace App\System;

use App\System\Interfaces\ApplicationInterface;

class Application implements ApplicationInterface
{

    function registerRoutes(): array
    {
        // TODO: Implement registerRoutes() method.
    }

    function runAction(string $controller_name, string $action_name, array $params): void
    {
        // TODO: Implement runAction() method.
    }
}