<?php

namespace App\Controller\Admin;

use App\System\Classes\Controller;
use App\System\Classes\Exceptions\UnauthorizedException;
use App\System\Classes\Services\Env;
use App\System\Interfaces\HTTP\RequestInterface;

class DatabaseController extends Controller
{
    public function index()
    {
        return $this->render('admin/database');
    }

    public function migrate(RequestInterface $request)
    {
        $this->authenticate($request);

        $migration = new \Database\migration\Migration();
        $migration->up();

        return "migration完了";
    }

    public function refresh(RequestInterface $request)
    {
        $this->authenticate($request);

        $migration = new \Database\migration\Migration();
        $migration->refresh();

        return "refresh完了";
    }

    public function seed(RequestInterface $request)
    {
        $this->authenticate($request);

        $seed = new \Database\seeds\Seeder();
        $seed->run();

        return "seed完了";
    }

    public function refreshAndSeed(RequestInterface $request) {
        print $this->refresh() . '<br>';
        print $this->seed() . '<br>';

        return 'refresh&seed完了<br><a href="'. url('/home') . '">ホームへ</a>';
    }

    private function authenticate(RequestInterface $request)
    {
        $input_pass = $request->getPost('password', '');
        // 入力されたパスワードが管理者パスワードと一致するかチェック
        if ($input_pass = Env::get('ADMIN_PASSWORD')) {
            return true;
        }

        throw new UnauthorizedException('実行権限がありません。');
    }
}