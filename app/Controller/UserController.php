<?php

namespace App\Controller;

use App\Model\Tweet;
use App\Model\User;
use App\System\Controller;

class UserController extends Controller
{
    public function index($params) {
        $unique_name = $params['unique_name'];


        $user = new User();
        $sql = 'SELECT * FROM users where unique_name = :unique_name';
        $user_data = $user->fetch($sql, [
            ':unique_name' => $unique_name,
        ]);

        //ユーザー情報がなかったらhomeへ
        if ($user_data == false) {
            return $this->_redirect('/home');
        }

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

//    public function getUserFollowedId($params){
//
//        $unique_name = $params['unique_name'];
//        return $this->render('profile', [
//            'unique_name' => $unique_name,
//        ]);
//
//    }

}