<?php

use App\Kernel;
use App\System\Classes\Core\Application;

require_once '../vendor/autoload.php';
require_once '../app/System/Helpers/consoleLogger.php';

$isDebugMode = false;
if ($_GET['debugMode'] == 'on') {
    $isDebugMode = true;
}

//Application呼び出し
$application = new Application(true);
$request = $application->getRequest();

$kernel = new Kernel($request);
$response = $kernel->handle();

$application->setResponse($response);

$application->send();