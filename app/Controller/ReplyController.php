<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Classes\Controller;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class ReplyController extends Controller
{
    public function post(RequestInterface $request)
    {
        //返信先のツイートID
        $tweet_id = $request->getPost('tweet_id');
        //返信の内容
        $text = $request->getPost('text');

        //TODO:バリデーション

        //ログイン中のユーザーID
        $session = Service::call('session');
        $user_id = $session->get('user_id');

        $tweet = new Tweet();

        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
            'reply_to_id' => $tweet_id
        ]);

        $from = $request->getGet('from');

        if (! isset($from)) {
            $from = '/home';
        }
        return redirect($from);
    }
}