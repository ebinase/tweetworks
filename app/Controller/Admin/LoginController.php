<?php

namespace App\Controller\Admin;

use App\System\Classes\Controller;
use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Services\Env;
use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\RequestInterface;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // TODO:CSRF対策
        return $this->render('admin/login', [
            '_token' => CSRF::generate('/admin/login/auth'),
        ]);
    }

    public function auth(RequestInterface $request)
    {
        //TODO: データベースを使った認証に切り替え
        $input_pass = $request->getPost('password', false);
        $admin_pass = Env::get('ADMIN_PASSWORD', '');
        // 入力されたパスワードが管理者パスワードと一致するかチェック
        if ($input_pass === $admin_pass) {
            $session = Service::call('session');
            // セッション情報をクリア(事前に通常ユーザーログインしていた場合への対応)
            $session->clear();
            $session->setAdminAuthenticated(true);

            Info::set('login', '管理者ログインしました。');

            return redirect('/admin/top');
        }

        Info::set('login', 'ログインに失敗しました。');
        return redirect('/admin/login');
    }

    public function logout()
    {
        $session = Service::call('session');
        $session->clear();
        $session->setAdminAuthenticated(false);

        Info::set('logout', 'ログアウトしました。');

        return redirect('/admin/login');
    }
}