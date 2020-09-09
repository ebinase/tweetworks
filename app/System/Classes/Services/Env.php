<?php

namespace App\System\Classes\Services;

use App\System\Classes\Facades\App;
use Dotenv\Dotenv;

class Env
{
    private static $dotenv;

    //実行しなくてもget()は使えるが、Application起動時に明示的に使用
    public static function boot()
    {
        $dotenv = Dotenv::createImmutable(App::rootDir());
        $dotenv->load();
    }

    //$nameに該当する.envファイルの中身を取得。万が一Applicationでboot()を実行し忘れても自動でbootしてから実行
    public static function get($name)
    {
        if((self::$dotenv instanceof Dotenv) === false){
            self::boot();
        }

        return $_ENV[$name];
    }

    public static function update($name, $value)
    {
        $_ENV[$name] = $value;
    }

}