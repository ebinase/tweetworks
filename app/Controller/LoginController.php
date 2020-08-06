<?php

namespace App\Controller;

use App\Model\User;
use App\System\Controller;

class LoginController extends Controller
{
    public function showLoginForm() {
        // ログイン済みの場合はホームに飛ばす
        if ($this->_session->isAuthenticated()) {
            // TODO: エラーメッセージ追加(ログイン済みです、など)
            return $this->_redirect('/home');
        }

        // TODO: old()による入力値の補完
        return $this->render('auth/login', [
            'unique_id' => '',
            'password' => '',
            '_token' => $this->_generateCsrfToken('login'),
        ]);
    }

    public function auth() {
        // ログイン状態チェック
        if ($this->_session->isAuthenticated()) {
            // TODO: エラーメッセージ追加(ログイン済みです、など)
            return $this->_redirect('/home');
        }

        if (! $this->_request->isPost()){
            $this->_forward404();
        }

        // CSRF対策
        $token = $this->_request->getPost('_token');
        if(! $this->_checkCsrfToken('login', $token)) {
            $this->_messenger->setError('csrf', 'エラーが発生しました。はじめからやり直してください。');
            $this->_redirect('/login');
        }

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
            return $this->_redirect('/home');
        }

        //　認証に失敗したらログインページにリダイレクト
        // TODO:スロットル機能(ログイン試行回数制限)機能
        $this->_messenger->setError('login', 'ログイン情報が間違っています。');
        return $this->_redirect('/login');
    }

    public function logout() {
        $this->_session->clear();
        $this->_session->setAuthenticated(false);

        return $this->_redirect('/home');
    }
}