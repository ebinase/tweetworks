<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Service;

class Admin
{
    /**
     * @return bool
     */
    public static function check()
    {
        $session = Service::call('session');
        return $session->isAdminAuthenticated();
    }

}