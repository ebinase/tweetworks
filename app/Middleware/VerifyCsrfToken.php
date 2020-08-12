<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Middleware;

class VerifyCsrfToken extends Middleware
{
    public function handle(Application $application): Application
    {
        $token = $application->getRequest()->getPost('_token');
        //TODO:修正
        $path = '/hogehoge';
        if(! $application->checkCsrfToken($path, $token)) {
//            $this->_messenger->setError('csrf', 'エラーが発生しました。はじめからやり直してください。');
            $application->redirect($path);
        }
        return $application;
    }
}