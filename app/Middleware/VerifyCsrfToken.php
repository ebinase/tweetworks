<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Middleware;

class VerifyCsrfToken extends Middleware
{
    public function handle(Application $application): Application
    {
        $token = $application->getRequest()->getPost('_token');
        //TODO:もといたフォームページへのパスの取得方法
        //REFFERERは危険。Messengerの利用が手軽？
        $path = '/hogehoge';
        if(! $application->checkCsrfToken($path, $token)) {
//            $this->_messenger->setError('csrf', 'エラーが発生しました。はじめからやり直してください。');
            $application->redirect($path);
        }
        return $application;
    }
}