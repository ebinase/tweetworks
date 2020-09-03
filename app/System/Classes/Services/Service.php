<?php

namespace App\System\Classes\Services;

use App\System\Classes\DatabaseConnection;
use App\System\Classes\Messenger;
use Pimple\Container;

use App\System\Classes\HTTP\Request;
use App\System\Classes\HTTP\Session;
use App\System\Classes\Route;

class Service
{
    private static $container;


    /**
     * pimpleのDIコンテナを起動＆設定読み込み
     * 実行しなくてもcall()は使えるが、Application起動時に明示的に使用
     */
    public static function boot() :void
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

        self::$container['connection'] = function ($c) {
            return new DatabaseConnection();
        };

        self::$container['messenger'] = function ($c) {
            return new Messenger($c['session']);
        };
    }

    //コンテナ内のインスタンスを取得。万が一Applicationでboot()を実行し忘れても自動でbootしてから実行
    public static function call($name)
    {
        if((self::$container instanceof Container) === false) {
            self::boot();
        }
        return self::$container[$name];
    }
}