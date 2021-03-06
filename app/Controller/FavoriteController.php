<?php

namespace App\Controller;

use App\Model\Favorite;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\HTTP\JsonResponse;
use App\System\Interfaces\HTTP\RequestInterface;

class FavoriteController extends Controller
{
    public function update(RequestInterface $request)
    {
        //ログイン中のユーザーid
        $user_id = Auth::id();

        //ajax(post)で送られてきたツイートid
        $tweet_id = $request->getPost('tweet_id');


        $favorite = new Favorite();
        //すでにお気に入りしてるかチェック
        $count = $favorite->checkIfFavoriteTweet($user_id, $tweet_id);

        if ($count == 0) {
            $favorite->smartInsert([
                'user_id' => $user_id,
                'tweet_id' => $tweet_id,
            ]);
            $result = 'set';
        } else {
            $favorite->unsetUsersFav($user_id, $tweet_id);
            $result = 'unset';
        }
//
        $favs = $favorite->countFavs($tweet_id);

        $content = [
            'result' => $result,
            'favs' => $favs,
        ];

        $response = new JsonResponse();

        $response->prepareJson($content);

        return $response;
    }
}