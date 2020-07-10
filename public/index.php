<?php

use App\System\Application;

require_once '../vendor/autoload.php';

//Application呼び出し
$application = new Application();
$application->run();