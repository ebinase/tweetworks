<?php

namespace App\System;

use App\System\Interfaces\SessionInterface;

class Session implements SessionInterface
{
    protected static  $sessionStarted = false;
    protected static  $sessionIdRegenerated = false;

    public  function __construct()
    {
        if (!self::$sessionStarted){
            session_start();

            self::$sessionStarted = true;
        }

    }


    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = null)
    {
        if (isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return  $default;

    }

    public function remove(string $name)
    {
        unset($_SESSION[$name]);

    }

//clearメソッド→$_SESSIONを空にする
    public function clear():void
    {
        $_SESSION = array();
    }

    public function regenerate($destroy = true):void
    {
        if (!self::$sessionIdRegenerated){
        session_regenerate_id($destroy);

        self::$sessionIdRegenerated = true;
        }
    }

    public function setAuthenticated($bool)
    {
        $this->set('_authenticated',(bool)$bool);

        $this->regenerate();
    }

    public function isAuthenticated()
    {
        return $this->get('_authenticated',false);
    }
}
