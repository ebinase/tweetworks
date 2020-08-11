<?php

use App\Kernel;
use App\System\Application;

require_once '../vendor/autoload.php';
require_once '../app/System/Helper/consoleLogger.php';

$isDebugMode = false;
if ($_GET['debugMode'] == 'on') {
    $isDebugMode = true;
}

//Application呼び出し
$application = new Application(true);

$kernel = new Kernel($application);
//$kernel->handle();
//
//$application->send();