<?php
namespace App\System\Classes

class GlobalManager
{
    public static function isSessionDtarted() {
        $session = $GLOBALS['session'];
        $session->isSseessionStarted();
    }
}