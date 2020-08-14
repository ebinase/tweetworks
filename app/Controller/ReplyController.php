<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Controller;

class ReplyController extends Controller
{
    public function post()
    {
        //返信先のツイートID
        $tweet_id = $this->_request->getPost('tweet_id');
        //返信の内容
        $text = $this->_request->getPost('text');

        //TODO:バリデーション

        //ログイン中のユーザーID
        $user_id = $this->_session->get('user_id');

        $tweet = new Tweet();

        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
            'reply_to_id' => $tweet_id
        ]);

        $from = $this->_request->getGet('from');

        if (! isset($from)) {
            $from = '/home';
        }
        $this->_application->redirect($from);
    }
}