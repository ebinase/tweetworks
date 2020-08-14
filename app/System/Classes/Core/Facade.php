<?php

namespace App\System;

use App\System\Interfaces\Facade\FacadeInterface;
use App\System\Interfaces\Facade\FacadeManagerInterface;

class Facade implements FacadeManagerInterface
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function get($facade):FacadeInterface
    {
        $facade_class = 'App\\System\\Facades\\' . $facade;
        return new $facade_class($this->app);
    }
}