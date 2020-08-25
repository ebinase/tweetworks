<?php

use App\Kernel;
use App\System\Classes\Core\Application;

require_once '../vendor/autoload.php';

//Application呼び出し
$application = new Application();
$request = $application->getRequest();

//ミドルウェアのリストを作成
$kernel = new Kernel($request);
//コントローラ呼び出しハンドラとミドルウェアたちをインスタンス化して一連のパイプラインを作成
$pipeline = $kernel->build();   //内部でnewするため依存性高め

//パイプラインを元にミドルウェアとハンドラを実行してレスポンスを生成。
$response = $kernel->handle($request, $pipeline);

//レスポンスをセット
$application->setResponse($response);

//送信
$application->send();