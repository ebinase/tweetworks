<?php

namespace App\System\Interfaces\Core;

use App\System\Application;
use App\System\Components\Messenger;
use App\System\Request;
use App\System\Response;
use App\System\Route;
use App\System\Session;

interface SingletonInterface
{
    // Kernelに利用されるクラスホルダーとしての機能。
    function getRequest():Request;
    function getResponse():Response;
    function getRoute():Route;
    function getSession():Session;
    function getMessenger():Messenger;
}