<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Interfaces\Core\MiddlewareInterface;

class Guest implements MiddlewareInterface
{

    public function process(Application $application): Application
    {
        //ログイン済みだったらホームにリダイレクト
        if ($application->getSession()->isAuthenticated() === true) {
            $application->redirect('/home');
        }

        print '<p>Guest通過</p>';
        return $application;
    }
}