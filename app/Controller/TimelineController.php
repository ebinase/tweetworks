<?php

namespace App\Controller;

use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Interfaces\HTTP\RequestInterface;

use App\Model\Tweet;
use App\System\Classes\Facades\CSRF;

class TimelineController extends Controller
{
    public function home(RequestInterface $request)
    {
        $start = $request->getGet('p', 1);

        $tweet = new Tweet();



        $tweets = $tweet->getTimeline(Auth::id(), $start, 50);

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');
        $_token['/reply/post'] = CSRF::generate('/reply/post');
        $_token['/tweet/delete'] = CSRF::generate('/tweet/delete');

        return $this->render('home', [
            '_token' => $_token,
            'tweets' => $tweets,
        ], 'layouts/layout');
    }

    public function all(RequestInterface $request)
    {
        //TODO:ペジネーション
        $page = $request->getGet('page',1);

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');
        $_token['/reply/post'] = CSRF::generate('/reply/post');
        $_token['/tweet/delete'] = CSRF::generate('/tweet/delete');

        $tweet  = new Tweet();
        //ユーザーがログイン中はお気に入りのツイート表示
        $data =$tweet->getAllTweetExceptReply(Auth::id(), $page, 50);

        return $this->render('all', [
            'data' => $data,
            '_token' => $_token,
        ], 'layouts/layout');
    }
}