<?php

namespace App\System\Classes\Facades;

class App
{
    /**
     * Applicationが起動した際の環境(本番かテストか)を判定できる。
     *
     * 引数無しで使うと、現在の環境名を取得できる。
     * 引数を入れると、引数と一致する環境かどうかをチェックできる。
     *
     * @param $name void | string  省略可。入れる場合は環境の名前。debugなど。
     * @return    string | bool    現在の環境名、または、引数と環境名が一致するかどうかを返す。
     */
    public static function environment($name = null)
    {

    }

    public static function rootDir()
    {
        return str_replace('/app/System/Classes/Facades/App.php', '', __FILE__);
    }

    public static function controllerDir()
    {
        return self::rootDir() . '/app/Controller';
    }

    public static function viewDir()
    {
        return self::rootDir() . '/resources/views';
    }

    public static function modelDir()
    {
        return self::rootDir() . '/app/Model';
    }

    public static function routeDir()
    {
        return self::rootDir() . '/route';
    }

    public static function configDir()
    {
        return self::rootDir() . '/config';
    }
}