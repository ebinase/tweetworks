<?php

namespace App\Controller;

use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Facades\Paginate;
use App\System\Interfaces\HTTP\RequestInterface;

use App\Model\Tweet;
use App\System\Classes\Facades\CSRF;

class TimelineController extends Controller
{
    public function home(RequestInterface $request)
    {
        $tweet = new Tweet();

        //ペジネーション
        //ペジネーション用に表示される可能性がある全てのツイートの数を取得
        $tweets_num = $tweet->countTimelineTweets(Auth::id());

        //タイムラインに表示できるツイートがあったらツイート取得
        if ($tweets_num != 0) {
            $paginate = Paginate::prepareParams(30 , 3, $tweets_num);
            //表示するツイートを取得
            $tweets = $tweet->getTimeline(Auth::id(), $paginate['db_start'], $paginate['items_per_page']);
        } else {
            $paginate = [];
            $tweets = [];
        }

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');
        $_token['/reply/post'] = CSRF::generate('/reply/post');
        $_token['/tweet/delete'] = CSRF::generate('/tweet/delete');

        return $this->render('home', [
            '_token' => $_token,
            'tweets' => $tweets,
            'paginate' => $paginate,
        ], 'layouts/layout');
    }

    public function all(RequestInterface $request)
    {
        $tweet  = new Tweet();

        $tweets_num = $tweet->countAllTweets();
        if ($tweets_num != 0) {
            $paginate = Paginate::prepareParams(30 , 3, $tweets_num);
            //ユーザーがログイン中はお気に入りのツイート表示
            $tweets = $tweet->getAllTweetExceptReply(Auth::id(), $paginate['db_start'], $paginate['items_per_page']);
        } else {
            $paginate = [];
            $tweets = [];
        }

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');
        $_token['/reply/post'] = CSRF::generate('/reply/post');
        $_token['/tweet/delete'] = CSRF::generate('/tweet/delete');


        return $this->render('all', [
            '_token' => $_token,
            'tweets' => $tweets,
            'paginate' => $paginate,
        ], 'layouts/layout');
    }
}