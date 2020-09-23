<?php

namespace App\System\Classes\HTTP;

use App\System\Interfaces\HTTP\SessionInterface;

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

    public function setAuthenticated(bool $bool)
    {
        // ログイン状態を上書き
        $this->set('_authenticated', $bool);

        // 念の為、管理者ログインをfalseに上書き
        $this->set('_admin_authenticated', false);

        $this->regenerate();
    }

    public function isAuthenticated()
    {
        return $this->get('_authenticated',false);
    }

    public function setAdminAuthenticated(bool $bool)
    {
        // 管理者ログイン状態を上書き
        $this->set('_admin_authenticated', $bool);

        // 念の為、通常ユーザーログインをfalseに上書き
        $this->set('_authenticated', false);

        $this->regenerate();
    }

    public function isAdminAuthenticated()
    {
        return $this->get('_admin_authenticated',false);
    }
}
