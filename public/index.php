<?php

use App\Kernel;
use App\System\Classes\Core\Application;
use Dotenv\Dotenv;

require_once '../vendor/autoload.php';
require_once '../app/System/Helpers/consoleLogger.php';

$isDebugMode = false;
if ($_GET['debugMode'] == 'on') {
    $isDebugMode = true;
}

//Application呼び出し
$application = new Application(true);
$request = $application->getRequest();
print_r($request);

//ミドルウェアのリストを作成
$kernel = new Kernel($request);
//コントローラ呼び出しハンドラとミドルウェアたちをインスタンス化して一連のパイプラインを作成
$pipeline = $kernel->build();   //内部でnewするため依存性高め
print_r($pipeline);
////パイプラインを元にミドルウェアとハンドラを実行してレスポンスを生成。
//$response = $kernel->handle($request, $pipeline);
//
////レスポンスをセット
//$application->setResponse($response);
//
////送信
//$application->send();