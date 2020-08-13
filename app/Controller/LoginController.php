<?php

namespace App\Controller;

use App\Model\User;
use App\System\Controller;

class LoginController extends Controller
{
    public function showLoginForm() {
        // TODO: old()による入力値の補完
        return $this->render('auth/login', [
            'unique_id' => '',
            'password' => '',
            '_token' => $this->_application->generateCsrfToken('/login/auth'),
        ]);
    }

    public function auth()
    {
        //ユーザー入力値取得
        $unique_name = $this->_request->getPost('unique_name');
        $password = $this->_request->getPost('password');
        //TODO: バリデーション

        // DBからunique_nameをキーにユーザーデータ取得(配列)
        $user = new User();
        $db_data = $user->fetchByUniqueName($unique_name);

        //パスワードが一致したらログイン処理
        if (password_verify($password, $db_data['password'])) {
            $this->_session->setAuthenticated(true);
            //ログイン後にユーザー関連の処理を行いやすいよう、セッションにidを登録
            $this->_session->set('user_id' ,$db_data['id']);
            $this->_application->redirect('/home');
        }

        //　認証に失敗したらログインページにリダイレクト
        // TODO:スロットル機能(ログイン試行回数制限)機能

        $this->_application->redirect('/login');
    }

    public function logout() {
        $this->_session->clear();
        $this->_session->setAuthenticated(false);

        $this->_application->redirect('/home');
    }
}