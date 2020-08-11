<?php

namespace App\System;

use App\System\Interfaces\Core\MiddlewareInterface;

abstract class Middleware implements MiddlewareInterface
{
    public abstract function handle(Application $application): Application;
}