<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Interfaces\Core\MiddlewareInterface;

class Authenticate implements MiddlewareInterface
{

    public function process(Application $application): Application
    {
        //ログインしていなかったらログインページにリダイレクト
        if ($application->getSession()->isAuthenticated() === false) {
            $application->redirect('/login');
        }

        //ログイン中のユーザーIDがセッションに記録されてなかったら再ログインしてもらう
        if (is_null($application->getSession()->get('user_id'))) {
            $application->redirect('/login');
        }

        print '<p>Authenticate通過</p>';
        return $application;
    }
}