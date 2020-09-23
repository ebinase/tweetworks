<?php

namespace App\Controller\Auth;

use App\Model\User;
use App\System\Classes\Controller;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class LoginController extends Controller
{
    public function showLoginForm() {
        // TODO: old()による入力値の補完
        return $this->render('auth/login', [
            'unique_id' => '',
            'password' => '',
            '_token' => CSRF::generate('/login/auth'),
        ], 'layouts/layout');
    }

    public function auth(RequestInterface $request)
    {
        //ユーザー入力値取得
        $unique_name = $request->getPost('unique_name');
        $password = $request->getPost('password');

        // DBからunique_nameをキーにユーザーデータ取得(配列)
        $user = new User();
        $db_data = $user->fetchByUniqueName($unique_name);

        //パスワードが一致したらログイン処理
        if (password_verify($password, $db_data['password'])) {
            $session = Service::call('session');
            // セッション情報をクリア(事前に管理者ログインしていた場合への対応)
            $session->clear();
            $session->setAuthenticated(true);
            //ログイン後にユーザー関連の処理を行いやすいよう、セッションにidとユーザーネームを登録
            $session->set('user_id' ,$db_data['id']);
            $session->set('name' ,$db_data['name']);
            $session->set('unique_name' ,$db_data['unique_name']);

            Info::set('login', 'ログインしました。');

            return redirect('/home');
        }

        //　認証に失敗したらログインページにリダイレクト
        // TODO:スロットル機能(ログイン試行回数制限)機能

        Info::set('login', 'ログインに失敗しました。');
        return redirect('/login');
    }

    public function logout() {
        $session = Service::call('session');
        $session->clear();
        $session->setAuthenticated(false);

        Info::set('logout', 'ログアウトしました。');

        return redirect('/');
    }
}