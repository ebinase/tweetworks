<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Service;

class Auth
{
    /**
     * @return bool
     */
    public static function check()
    {
        $session = Service::call('session');
        return $session->isAuthenticated();
    }

    /**
     * @return string | null
     */
    public static function id()
    {
        $session = Service::call('session');
        return $session()->get('user_id', null);
    }
}