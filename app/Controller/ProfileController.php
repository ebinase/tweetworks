<?php

namespace App\Controller;

use App\Model\Follow;
use App\Model\Tweet;
use App\Model\User;
use App\Request\ProfileValidator;
use App\System\Classes\Controller;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Facades\Paginate;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class ProfileController extends Controller
{

    //任意のユーザーのツイート一覧などを表示する(マイページのようなログイン必須のものではない)
    public function index(RequestInterface $request) {
        //urlから取得したユニークネームをもとにユーザーデータをDBから取り出す。
        $user_data = $this->_getUserDataFromUname($request);

        //ユーザー情報がなかったら戻る
        if ($user_data === false) {
            Info::set('not_found', 'ユーザー情報が存在しません');
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
        $_token['/profile/update'] = CSRF::generate('/profile/update');

        $follow_state = $follow->checkIfFollows(Auth::id(),$user_data['id']);

        $tweet = new Tweet();

        if($request->getGet('content') === 'favorites') {
            //お気に入りツイート一覧を要求されたら
            $tweets_num = $tweet->countProfileFavorites($user_data['id']);
            if ($tweets_num != 0) {
                $paginate = Paginate::prepareParams(20 , 3, $tweets_num);
                $tweets = $tweet->getFavoriteTweets($user_data['id'], Auth::id(), $paginate['db_start'], $paginate['items_per_page']);
            } else {
                $paginate = [];
                $tweets = [];
            }
            //現在表示中のコンテンツをビューで表示するための設定
            $active['fav'] = 'profile-active';

        } elseif($request->getGet('content') === 'replies') {
            //リプライ一覧を要求されたら
            $tweets_num = $tweet->countProfileReplies($user_data['id']);
            if ($tweets_num != 0) {
                $paginate = Paginate::prepareParams(20 , 3, $tweets_num);
                $tweets = $tweet->getUserReplies($user_data['id'], Auth::id(), $paginate['db_start'], $paginate['items_per_page']);
            } else {
                $paginate = [];
                $tweets = [];
            }
            //現在表示中のコンテンツをビューで表示するための設定
            $active['rep'] = 'profile-active';

        } else {
            //該当するユーザーが存在したら
            //ツイート一覧表示
            $tweets_num = $tweet->countProfileTweets($user_data['id']);
            if ($tweets_num != 0) {
                $paginate = Paginate::prepareParams(20 , 3, $tweets_num);
                $tweets = $tweet->getUserTweets($user_data['id'], Auth::id(), $paginate['db_start'], $paginate['items_per_page']);
            } else {
                $paginate = [];
                $tweets = [];
            }
            //現在表示中のコンテンツをビューで表示するための設定
            $active['twe'] = 'profile-active';
        }




        return $this->render('profile', [
            'user' => $user_data,
            'tweets' => $tweets,
            'follow' => $follow_num,
            '_token' => $_token,
            'paginate' => $paginate,
            'active' => $active,
            'follow_state' => $follow_state,
        ], 'layouts/layout');
    }

    public function followsIndex(RequestInterface $request)
    {
        $user_data = $this->_getUserDataFromUname($request);

        //ユーザー情報がなかったら戻る
        if ($user_data === false) {
            Info::set('not_found', 'ユーザー情報が存在しません');
            return back();
        }

        $follow = new Follow();
        // TODO:フォローしているかどうか、自分自身のアカウントかどうか確認する機能
        $follows = $follow->getFollowsIndex($user_data['id']);

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');

        return $this->render('user/users-index', [
            'users' => $follows,
            'title' => 'フォロー',
            '_token' => $_token,
        ], 'layouts/layout');
    }

    public function followersIndex(RequestInterface $request)
    {
        $user_data = $this->_getUserDataFromUname($request);

        //ユーザー情報がなかったら戻る
        if ($user_data === false) {
            Info::set('not_found', 'ユーザー情報が存在しません');
            return back();
        }

        $follow = new Follow();
        $followers = $follow->getFollowersIndex($user_data['id']);

        $_token['/tweet/post'] = CSRF::generate('/tweet/post');

        return $this->render('user/users-index', [
            'users' => $followers,
            'title' => 'フォロワー',
            '_token' => $_token
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

    public function update(RequestInterface $request)
    {
        ProfileValidator::validate($request);

        $name = $request->getPost('name');
        $bio = $request->getPost('bio');

        $user = new User();

        $user->smartUpdate([
            'name' => $name,
            'bio' => $bio,
        ], [
            'id' => Auth::id(),
        ]);

        $session = Service::call('session');
        $session->set('name' ,$name);

        return back('/home');
    }
}