<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Interfaces\Core\MiddlewareInterface;

class Authenticate implements MiddlewareInterface
{

    public function handle(Application $application): Application
    {
        //ログインしていなかったらログインページにリダイレクト
        if ($application->getSession()->isAuthenticated() === false) {
            $application->redirect('/login');
        }

        print '<p>Authenticate通過</p>';
        return $application;
    }
}