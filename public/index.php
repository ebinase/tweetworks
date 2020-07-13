<?php

use App\System\Application;

require_once '../vendor/autoload.php';
require_once '../app/System/Helper/consoleLogger.php';

//Application呼び出し
$application = new Application();
$application->run();