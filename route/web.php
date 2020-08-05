<?php

use App\System\Route;

function registerWebRoutes(Route $route)
{

    $route->get('/sign-up', 'register', 'showSignupPage');
    $route->post('/sign-up/confirm', 'register', 'confirm');
    $route->post('/sign-up/register', 'register', 'register');

    $route->get('/login', 'login', 'showLoginForm');
    $route->post('/login/auth', 'login', 'auth');

    $route->post('/logout', 'login', 'logout');

    $route->get('/home', 'tweet', 'home');

    $route->post('/tweet/post', 'tweet', 'post', 1);
    $route->post('/tweet/delete', 'tweet', 'delete', 1);

    $route->get('/migrate', 'database', 'migrate');
    $route->get('/refresh', 'database', 'refresh');
    $route->get('/seed', 'database', 'seed');

}