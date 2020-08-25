<?php

namespace App\Controller;

use App\Model\User;
use App\System\Classes\Controller;
use App\System\Classes\Facades\CSRF;
use App\System\Interfaces\HTTP\RequestInterface;

class RegisterController extends Controller
{
    public function showSignupPage()
    {
        return $this->render('sign-up', [
            '_token' => CSRF::generate('/sign-up/confirm'),
        ], 'layouts/layout');
    }

    public function confirm(RequestInterface $request)
    {

        // TODO: バリデーション
        $name = $request->getPost('name');
        $email = $request->getPost('email');
        $unique_name = $request->getPost('unique_name');
        $password = $request->getPost('password');

        // emailの重複チェック
        $user = new User();
        $sql = 'select email from users where email = :email;';
        $existing_email = $user->fetchAll($sql, [
            ':email' => $email,
        ]);
        // 重複が存在したら登録ページにリダイレクト
        if (count($existing_email) > 0) {
            return redirect('/sign-up');
        }

        $secret = '';
        for ( $i = 0; $i < mb_strlen($password); $i++) {
            $secret .= '*';
        }

        return $this->render('confirm', [
            '_token' => CSRF::generate('sign-up/confirm'),
            'name' => $name,
            'email' => $email,
            'unique_name' => $unique_name,
            'password' => $password,
            'secret' => $secret,
        ], 'layouts/layout');
    }

    public function register(RequestInterface $request)
    {
        // TODO:バリデーションそれからエスケープ処理

        // パスワードにランダムなソルトをつけた上でハッシュ化
        // 第２引数をDEFAULTにすると各PHPのバージョンに最適な暗号化形式を自動選択
        $hash_pass = password_hash($request->getPost('password'), PASSWORD_DEFAULT);

        // Userモデルを呼び出して登録処理
        $user = new User();
        $user->smartInsert([
            'name' => $request->getPost('name'),
            'email' => $request->getPost('email'),
            'unique_name' => $request->getPost('unique_name'),
            'password' => $hash_pass,
        ]);

        return redirect('/home');
    }
}