<?php

namespace App\Controller;

use App\Model\Tweet;
use App\System\Classes\Controller;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class TweetController extends Controller
{
    public function post(RequestInterface $request)
    {
        // エラー格納用変数準備
        $errors = [];

        //テキストのバリデーション
        $text = $request->getPost('text');
        if (!strlen($text)) {
            $errors['text'] = '１文字以上入力してください。';
        } elseif (mb_strlen($text) > 140) {
            $errors['text'] = 'ツイートは140文字までです。';
        }
        if(count($errors) !== 0) {
            //エラーが生じたらメッセージを添えてタイムラインに戻る。
            return redirect('/home');
        }

        $session = Service::call('session');
        // エラーがなかったら投稿してタイムラインに戻る
        $user_id = $session->get('user_id');

        $tweet = new Tweet();
        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
        ]);
        return redirect('/home');
    }

    public function delete(RequestInterface $request) {
        $tweet_id = $request->getPost('tweet_id');

        $tweet = new tweet();

        // TODO: ログイン中のユーザーと削除する投稿のuser_idが等しいかチェック
        $session = Service::call('session');
        $session->get('user_id');

        $tweet->deleteById($tweet_id);

        return redirect('/home');
    }

    public function home()
    {

        $_token['tweet/post'] = CSRF::generate('tweet/post');
        $_token['tweet/delete'] = CSRF::generate('tweet/delete');
        return $this->render('home', [
            '_token' => $_token
        ], 'layouts/layout');
    }

    public function all()
    {
        $tweet  = new Tweet();
        $data =$tweet->getAllTweet();

        return $this->render('all', [
              'data' => $data,
        ], 'layouts/layout');
    }

    public function detail(RequestInterface $request)
    {
        //urlからツイートIDの値を取得
        $params = $request->getRouteParam();
        $tweet_id = $params['tweet_id'];

        $tweet  = new Tweet();

        $data = $tweet->getDetailTweet($tweet_id);
        $replies = $tweet->getReplies($tweet_id);

        return $this->render('detail', [
            'data' => $data,
            'replies' => $replies,
            '_token' => [
                '/reply/post' => CSRF::generate('/reply/post'),
                '/tweet/delete' => CSRF::generate('/tweet/delete'),
                ],
            ],
            'layouts/layout'
        );
    }
}