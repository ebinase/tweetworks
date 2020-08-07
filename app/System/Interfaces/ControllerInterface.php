<?php

namespace App\System\Interfaces;

use App\System\Application;

interface ControllerInterface
{
    function __construct(Application $application);

    function run(string $action_name, array $params): string;
}