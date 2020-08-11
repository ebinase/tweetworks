<?php

namespace App\System\Interfaces\Core;

use App\System\Application;

interface MiddlewareInterface
{
    public function handle(Application $application): Application;
}