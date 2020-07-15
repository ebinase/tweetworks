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


    public function set(string $name, string $value)
    {
        $_SESSION[$name] = $value;
    }

    function get(string $name, $default = null)
    {
        if (isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return  $default;

    }

    function remove(string $name)
    {
        unset($_SESSION[$name]);

    }

//clearメソッド→$_SESSIONを空にする
    public function clear():void
    {
        $_SESSION = array();
    }

    function regenerate($destroy = true):void
    {
        // TODO: Implement regenerate() method.
        if (!self::$sessionIdRegenerated){
        session_regenerate_id($destroy);

        self::$sessionIdRegenerated = true;
        }
    }

    function setAuthenticated($bool)
    {
        $this->set('_authenticated',(bool)$bool);

        $this->regenerate();
    }

    function isAuthenticated()
    {
        return $this->get('_authenticated',false);
    }
}
