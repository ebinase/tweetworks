<?php

namespace App\Controller;

use App\Model\Tweet;
use App\Request\TweetValidator;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class TweetController extends Controller
{
    public function post(RequestInterface $request)
    {
        TweetValidator::validate($request);

        $text = $request->getPost('text');

        $session = Service::call('session');
        // エラーがなかったら投稿してタイムラインに戻る
        $user_id = $session->get('user_id');

        $tweet = new Tweet();
        $tweet->smartInsert([
            'user_id' => $user_id,
            'text' => $text,
        ]);

        Info::set('tweet', $text);
        return redirect('/home');
//        return back('/home');
    }

    public function delete(RequestInterface $request) {
        $tweet_id = $request->getPost('tweet_id');

        $tweet = new tweet();

        //削除対象のツイートのデータを配列で取得
        $tweet_data = $tweet->fetchById($tweet_id);

        //リクエストされたツイートのデータが存在し、かつログイン中のユーザー自身のツイートだった場合のみ削除する。
        if (empty($tweet_data['user_id'])) {
            Info::set('tweet_delete', '該当ツイートはすでに存在していません。');
        }
        elseif ( $tweet_data['user_id'] !== Auth::id()) {
            Info::set('unautholized', '他のユーザーのツイートを削除することはできません。');
            return back('/home');
        }
        else {
            $tweet->deleteById($tweet_id);
        }
        return redirect('/home');
    }


    public function show(RequestInterface $request)
    {
        //urlからツイートIDの値を取得
        $params = $request->getRouteParam();
        $tweet_id = $params['tweet_id'];

        $user_id = Auth::id();

        $tweet  = new Tweet();

        $main_tweet = $tweet->getDetailTweet($tweet_id, $user_id);

        if (empty($main_tweet)) {
            Info::set('not_found', 'ツイートが存在しません');
            return back('/home');
        }

        $replies = $tweet->getReplies($tweet_id, $user_id);

        return $this->render('detail', [
            'tweet' => $main_tweet,
            'replies' => $replies,
            '_token' => [
                '/reply/post' => CSRF::generate('/reply/post'),
                '/tweet/delete' => CSRF::generate('/tweet/delete'),
                '/tweet/post' => CSRF::generate('/tweet/post'),
                ],
            ],
            'layouts/layout'
        );
    }
}