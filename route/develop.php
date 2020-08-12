<?php

use App\System\Route;

function registerDevelopRoutes(Route $route)
{
    $route->group('develop', function ($route){
        $route->get('/migrate', 'database', 'migrate');
        $route->get('/refresh', 'database', 'refresh');
        $route->get('/seed', 'database', 'seed');
    });
}