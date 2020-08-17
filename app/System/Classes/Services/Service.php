<?php

namespace App\System\Classes\Services;

use Pimple\Container;

use App\System\Classes\HTTP\Request;
use App\System\Classes\HTTP\Session;
use App\System\Classes\Route;

class Service
{
    private static $container;

    public static function boot()
    {
        self::$container = new Container();

        self::$container['request'] = function ($c) {
            return new Request();
        };

        self::$container['session'] = function ($c) {
            return new Session();
        };

        self::$container['route'] = function ($c) {
            return new Route();
        };
    }

    public static function call($name) {
        return self::$container[$name];
    }
}