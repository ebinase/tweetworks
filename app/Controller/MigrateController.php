<?php

namespace App\Controller;

use App\System\Cotroller;

class MigrateController extends Cotroller
{
    public function migrate()
    {
        $migration = new \Database\migration\Migration();
        $migration->up();

        return "migration完了";
    }
}