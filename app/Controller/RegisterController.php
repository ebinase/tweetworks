<?php

namespace App\Controller;

use App\Model\User;
use App\System\Controller;

class RegisterController extends Controller
{
    public function showSignupPage()
    {
        return $this->render('sign-up', [
            '_token' => $this->_generateCsrfToken('sign-up'),
            'error' => $this->_messenger->getAllErrors(),
        ]);
    }

    public function confirm()
    {
        // TODO: HTTP_METHOD middleware的なもので処理したい
        if (! $this->_request->isPost()){
            $this->_forward404();
        }

        // CSRF対策
        $token = $this->_request->getPost('_token');
        if(! $this->_checkCsrfToken('sign-up', $token)) {
            $this->_messenger->setError('general', 'エラーが発生しました。');
            $this->_redirect('/sign-up');
        }

        // TODO: バリデーション
        $name = $this->_request->getPost('name');
        $email = $this->_request->getPost('email');
        $unique_name = $this->_request->getPost('unique_name');
        $password = $this->_request->getPost('password');

        // emailの重複チェック
        $user = new User();
        $sql = 'select email from users where email = :email;';
        $existing_email = $user->fetchAll($sql, [
            ':email' => $email,
        ]);
        // 重複が存在したら登録ページにリダイレクト
        if (count($existing_email) > 0) {
            $this->_redirect('/sign-up');
        }

        $secret = '';
        for ( $i = 0; $i < mb_strlen($password); $i++) {
            $secret .= '*';
        }

        return $this->render('confirm', [
            '_token' => $this->_generateCsrfToken('confirm'),
            'name' => $name,
            'email' => $email,
            'unique_name' => $unique_name,
            'password' => $password,
            'secret' => $secret,
        ]);
    }

    public function register()
    {
        if (! $this->_request->isPost()){
            $this->_forward404();
        }

        // CSRF対策
        $token = $this->_request->getPost('_token');
        if(! $this->_checkCsrfToken('confirm', $token)) {
            $this->_messenger->setError('general', 'エラーが発生しました。はじめからやり直してください。');
            $this->_redirect('/sign-up');
        }

        // TODO:バリデーションそれからエスケープ処理

        // パスワードにランダムなソルトをつけた上でハッシュ化
        // 第２引数をDEFAULTにすると各PHPのバージョンに最適な暗号化形式を自動選択
        $hash_pass = password_hash($this->_request->getPost('password'), PASSWORD_DEFAULT);

        // Userモデルを呼び出して登録処理
        $user = new User();
        $user->smartInsert([
            'name' => $this->_request->getPost('name'),
            'email' => $this->_request->getPost('email'),
            'unique_name' => $this->_request->getPost('unique_name'),
            'password' => $hash_pass,
        ]);

        return $this->_redirect('/home');
    }
}