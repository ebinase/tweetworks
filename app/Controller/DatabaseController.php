<?php

namespace App\Controller;

use App\System\Cotroller;

class DatabaseController extends Cotroller
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

}