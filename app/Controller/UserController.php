<?php

namespace App\Controller;

use App\Model\Favorite;
use App\Model\Follow;
use App\Model\Tweet;
use App\Model\User;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\CSRF;
use App\System\Interfaces\HTTP\RequestInterface;

class UserController extends Controller
{
    //任意のユーザーのツイート一覧などを表示する(マイページのようなログイン必須のものではない)
    public function index(RequestInterface $request) {
        //urlから取得したユニークネームをもとにユーザーデータをDBから取り出す。
        $user_data = $this->_getUserDataFromUname($request);

        //ユーザー情報がなかったらhomeへ
        if (! isset($user_data)) {
            return back();
        }

        //フォローフォロワー数取得
        $follow = new Follow();
        $follow_num['follows'] = $follow->countFollows($user_data['id']);
        $follow_num['followers'] = $follow->countFollowers($user_data['id']);


        $_token['/reply/post'] = CSRF::generate('/reply/post');
        $_token['/tweet/post'] = CSRF::generate('/tweet/post');
        $_token['/tweet/delete'] = CSRF::generate('/tweet/delete');
        $_token['/follow/update'] = CSRF::generate('/follow/update');



        if($request->getGet('content') == 'favorites') {
            //お気に入りツイート一覧を要求されたら
            $favorite = new Favorite();
            $tweets = $favorite->getFavoriteTweets($user_data['id'], Auth::id());
        } elseif($request->getGet('content') == 'replies') {
            $tweet = new Tweet();
            $tweets = $tweet->getUserReplies($user_data['id'], Auth::id());
        } else {
            //該当するユーザーが存在したら
            //ツイート一覧表示
            $tweet = new Tweet();
            $tweets = $tweet->getUserTweets($user_data['id'], Auth::id());
        }


        return $this->render('profile', [
            'user' => $user_data,
            'tweets' => $tweets,
            'follow' => $follow_num,
            '_token' => $_token,
        ], 'layouts/layout');
    }

    public function followsIndex(RequestInterface $request)
    {
        $user_data = $this->_getUserDataFromUname($request);

        $follow = new Follow();
        $follows = $follow->getFollowsIndex($user_data['id']);

        return $this->render('user/users-index', [
            'users' => $follows,
            'title' => 'フォロー',
        ], 'layouts/layout');
    }

    public function followersIndex(RequestInterface $request)
    {
        $user_data = $this->_getUserDataFromUname($request);

        $follow = new Follow();
        $followers = $follow->getFollowersIndex($user_data['id']);
        return $this->render('user/users-index', [
            'users' => $followers,
            'title' => 'フォロー',
        ], 'layouts/layout');
    }

    //urlから取得したユニークネームをもとにユーザーデータを取り出す。
    private function _getUserDataFromUname($request) {
        //urlから表示したいユーザーのユニークネームを取得
        $params = $request->getRouteParam();
        $unique_name = $params['unique_name'];

        //ユニークネーム(@hoge)からユーザー情報取得
        $user = new User();
        $sql = 'SELECT id, name, unique_name, bio, created_at, updated_at FROM users where unique_name = :unique_name';
        return $user->fetch($sql, [
            ':unique_name' => $unique_name,
        ]);
    }
}