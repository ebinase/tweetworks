<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Cotroller;

class TweetController extends Cotroller
{
    public function post($params)
    {
        if ($this->_request->isPost()){
            $this->_forward404();
        }

        //TODO:CSRF対策

        $errors = [];
        //テキストのバリデーション
        $text = $this->_request->get('text');
        if (!strlen($text)) {
            $errors['text'] = '１文字以上入力してください。';
        } elseif (mb_strlen($text) > 140) {
            $errors['text'] = 'ツイートは140文字までです。';
        }

        if (count($errors) === 0) {
            $user_id = $this->_session->get('user_id');
            $tweet = new Tweet();
            $tweet->insert($user_id, $text);
            return $this->_redirect('/home');
        }
        // TODO: エラーハンドラの実装
        return 'エラー出たよ';

    }

    public function home()
    {
        return 'ここはhome';
    }

}