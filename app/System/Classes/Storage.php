<?php
namespace App\System\Classes;

use App\System\Classes\HTTP\Session;

class Storage
{
    public static function registerFromArray(array $params)
    {
        foreach ($params as $key => $item) {
            $GLOBALS[$key] = $item;
        }
    }

    //ゲッター
    public static function session() {
        return  $GLOBALS['session'];
    }

}

$session = new Session();
Storage::registerFromArray(['session' => $session]);

var_dump(Storage::session());