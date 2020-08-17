<?php

use App\System\Interfaces\RouteInterface;

function registerDevelopRoutes(RouteInterface $route)
{
    $route->group('develop', function ($route){
        $route->get('/migrate', 'database', 'migrate');
        $route->get('/refresh', 'database', 'refresh');
        $route->get('/seed', 'database', 'seed');
        $route->get('/refresh-seed', 'database', 'refreshAndSeed');
    });
}