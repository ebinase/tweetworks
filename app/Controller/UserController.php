<?php

namespace App\Controller;

use App\Model\Tweet;
use App\Model\User;
use App\System\Classes\Controller;
use App\System\Interfaces\HTTP\RequestInterface;

class UserController extends Controller
{
    //任意のユーザーのツイート一覧などを表示する(マイページのようなログイン必須のものではない)
    public function index(RequestInterface $request) {
        //urlから表示したいユーザーの名前を取得
        $params = $request->getRouteParam();
        $unique_name = $params['unique_name'];

        //ユニークネーム(@hoge)からユーザー情報取得
        $user = new User();
        $sql = 'SELECT * FROM users where unique_name = :unique_name';
        $user_data = $user->fetch($sql, [
            ':unique_name' => $unique_name,
        ]);

        //ユーザー情報がなかったらhomeへ
        if ($user_data == false) {
            return redirect('/home');
        }

        //該当するユーザーが存在したらツイート一覧表示
        $tweet = new Tweet();
        $sql = 'SELECT * FROM tweets where user_id = :user_id ORDER BY created_at DESC;';
        $tweet_data = $tweet->fetchAll($sql, [
            ':user_id' => $user_data['id']
        ]);

        //TODO: $tweet_dataにもユーザー情報を含める

        return $this->render('profile', [
            'user' => $user_data,
            'tweets' => $tweet_data,
        ]);
    }
}