<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Controller;

class TweetController extends Controller
{
    public function post($params)
    {
        // エラー格納用変数準備
        $errors = [];

        //テキストのバリデーション
        $text = $this->_request->getPost('text', '');
        if (!strlen($text)) {
            $errors['text'] = '１文字以上入力してください。';
        } elseif (mb_strlen($text) > 140) {
            $errors['text'] = 'ツイートは140文字までです。';
        }
        if(count($errors) !== 0) {
            //エラーが生じたらメッセージを添えてタイムラインに戻る。
            $this->_messenger->setError('text', $errors['text']);
            return $this->_redirect('/home');
        }

        // エラーがなかったら投稿してタイムラインに戻る
        $user_id = $this->_session->get('user_id');
        print 'user_id:' . $user_id;
        $tweet = new Tweet();
        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
        ]);
        return $this->_redirect('/home');
    }

    public function delete() {
      $tweet_id = $this->_request->getPost('tweet_id');
        $user_id = $this->_session->get('user_id');

        $tweet = new tweet();

        // TODO: ログイン中のユーザーと削除する投稿のuser_idが等しいかチェック

        $tweet->deleteById($tweet_id);

        return  $this->_redirect('/home');
    }

    public function home()
    {

        $_token['tweet/post'] = $this->_generateCsrfToken('tweet/post');
        $_token['tweet/delete'] = $this->_generateCsrfToken('tweet/delete');
        return $this->render('home', [
            '_token' => $_token
        ]);
    }

    public function all()
    {
        $tweet  = new Tweet();
        $data =$tweet->getAllTweet();

        return $this->render('all', [
              'data' => $data,
        ]);
    }

    public function detail($params)
    {
        $tweet  = new Tweet();
        $data = $tweet->getDetailTweet($params);

        return $this->render('detail', [
            'data' => $data
            ]
        );
    }
}