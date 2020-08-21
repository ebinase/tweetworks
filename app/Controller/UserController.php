<?php

namespace App\Controller;

use App\Model\Follow;
use App\Model\Tweet;
use App\Model\User;
use App\System\Classes\Controller;
use App\System\Interfaces\HTTP\RequestInterface;

class UserController extends Controller
{
    //任意のユーザーのツイート一覧などを表示する(マイページのようなログイン必須のものではない)
    public function index(RequestInterface $request) {
        $user_data = $this->_getUserDataFromUname($request);

        //ユーザー情報がなかったらhomeへ
        if (! isset($user_data)) {
            return back();
        }

        //該当するユーザーが存在したら
        //ツイート一覧表示
        $tweet = new Tweet();
        $tweet_data = $tweet->getUserTweet($user_data['id']);

        //フォローフォロワー数取得
        $follow = new Follow();
        $follow_num['follows'] = $follow->countFollows($user_data['id']);
        $follow_num['followers'] = $follow->countFollowers($user_data['id']);

        //TODO: $tweet_dataにもユーザー情報を含める

        return $this->render('profile', [
            'user' => $user_data,
            'tweets' => $tweet_data,
            'follow' => $follow_num,
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

    private function _getUserDataFromUname($request) {
        //urlから表示したいユーザーのユニークネームを取得
        $params = $request->getRouteParam();
        $unique_name = $params['unique_name'];

        //ユニークネーム(@hoge)からユーザー情報取得
        $user = new User();
        $sql = 'SELECT id, name, unique_name,created_at, updated_at FROM users where unique_name = :unique_name';
        return $user->fetch($sql, [
            ':unique_name' => $unique_name,
        ]);
    }
}