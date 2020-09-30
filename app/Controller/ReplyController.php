<?php

namespace App\Controller;

use App\Model\Tweet;
use App\Request\TweetValidator;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class ReplyController extends Controller
{
    public function post(RequestInterface $request)
    {
        TweetValidator::validate($request);

        //返信先のツイートID
        $tweet_id = $request->getPost('tweet_id');
        //返信の内容
        $text = $request->getPost('text');

        $tweet = new Tweet();
        if ($tweet->smartCount('id', $tweet_id) == 0) {
            Info::set('not_found', '返信先のツイートが存在しません');
            return back('/home');
        }

        //ログイン中のユーザーID
        $session = Service::call('session');
        $user_id = $session->get('user_id');



        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
            'reply_to_id' => $tweet_id
        ]);

        return back('/home');
    }
}