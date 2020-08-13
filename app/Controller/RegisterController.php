<?php

namespace App\Controller;

use App\Model\User;
use App\System\Controller;

class RegisterController extends Controller
{
    public function showSignupPage()
    {
        return $this->render('sign-up', [
            '_token' => $this->_application->generateCsrfToken('/sign-up/confirm'),
        ]);
    }

    public function confirm()
    {

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
            $this->_application->redirect('/sign-up');
        }

        $secret = '';
        for ( $i = 0; $i < mb_strlen($password); $i++) {
            $secret .= '*';
        }

        return $this->render('confirm', [
            '_token' => $this->_application->generateCsrfToken('sign-up/confirm'),
            'name' => $name,
            'email' => $email,
            'unique_name' => $unique_name,
            'password' => $password,
            'secret' => $secret,
        ]);
    }

    public function register()
    {
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

        $this->_application->redirect('/home');
    }
}