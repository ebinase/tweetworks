<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Cotroller;

class TweetController extends Cotroller
{
    public function post($params)
    {
        if (! $this->_request->isPost()){
            $this->_forward404();
        }

        //TODO:CSRF対策

        //テキストのバリデーション
        $text = $this->_request->getPost('text', '');
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

        $this->_messenger->setError('text', $errors['text']);
        return $this->_redirect('/home');;

    }

    public function home()
    {
        return $this->render('home');
    }

}