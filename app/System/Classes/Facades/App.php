<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Env;

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
        $environment = Env::get('ENV_NAME');
        if (isset($name)) {
            //環境名と引数の文字が一致するかチェックしてboolを返す
            return $environment === $name;
        }
        //引数がなかったら環境名を返す。
        return Env::get('ENV_NAME');
    }

    public static function isDebugMode() :bool
    {
        return Env::get('APP_DEBUG') == 'true';
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

    public static function helperDir() {
        return self::rootDir() . '/app/System/Helpers';
    }
}