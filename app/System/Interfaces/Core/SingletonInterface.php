<?php

namespace App\System\Interfaces\Core;

use App\System\Application;
use App\System\Request;

interface SingletonInterface
{
    // Kernelに利用されるクラスホルダーとしての機能。
    function getRequest():Request;
    function getResponse();
    function getRoute();
    function getSession();
    function getMessenger();
}