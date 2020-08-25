<?php

namespace App\Controller;

use App\System\Classes\Controller;

class DatabaseController extends Controller
{
    public function migrate()
    {
        $migration = new \Database\migration\Migration();
        $migration->up();

        return "migration完了";
    }

    public function refresh()
    {
        $migration = new \Database\migration\Migration();
        $migration->refresh();

        return "refresh完了";
    }

    public function seed()
    {
        $seed = new \Database\seeds\Seeder();
        $seed->run();

        return "seed完了";
    }

    public function refreshAndSeed() {
        print $this->refresh() . '<br>';
        print $this->seed() . '<br>';

        return 'refresh&seed完了<br><a href="'. url('/home') . '">ホームへ</a>';
    }

}