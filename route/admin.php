<?php

use App\System\Interfaces\RouteInterface;

function registerAdminRoutes(RouteInterface $route)
{
    // TODO: group()の外側にもコードを書けるようにする。

    $route->group('admin', function ($route){


        $route->get('/admin/logout', 'Admin/Login', 'logout');

        $route->get('/admin/top', 'Admin/Admin', 'index');

        $route->get('/admin/database', 'Admin/Database', 'index');

        $route->get('/admin/database/migrate',         'Admin/Database', 'migrate');
        $route->get('/admin/database/refresh',         'Admin/Database', 'refresh');
        $route->get('/admin/database/seed',            'Admin/Database', 'seed');
        $route->get('/admin/database/refresh-seed',    'Admin/Database', 'refreshAndSeed');
    });
}