<?php
function getWebRoutes() {
    return [
        '/sign-up' => [
            'controller' => 'register',
            'action' => 'showSighupPage',
            'auth' => 0,
            'name' => 'hoge',
        ],

        '/sign-up/confirm' => [
            'controller' => 'register',
            'action' => 'confirm',
            'auth' => 0,
            'name' => null,
        ],

        '/sign-up/register' => [
            'controller' => 'register',
            'action' => 'register',
            'auth' => 0,
            'name' => null,
        ],

        '/login' => [
            'controller' => 'login',
            'action' => 'showLoginForm',
            'auth' => 0,
            'name' => null,
        ],

        '/login/auth' => [
            'controller' => 'login',
            'action' => 'auth',
            'auth' => 0,
            'name' => null,
        ],

        '/logout' => [
            'controller' => 'login',
            'action' => 'logout',
            'auth' => 0,
            'name' => null,
        ],

        '/home' => [
            'controller' => 'tweet',
            'action' => 'home',
            'auth' => 0,
            'name' => null,
        ],

        '/tweet/post' => [
            'controller' => 'tweet',
            'action' => 'post',
            'auth' => 0,
            'name' => 'hoge',
        ],

        '/migrate' => [
            'controller' => 'database',
            'action' => 'migrate',
            'auth' => 0,
            'name' => 'null',
        ],

        '/refresh' => [
            'controller' => 'database',
            'action' => 'refresh',
            'auth' => 0,
            'name' => 'null',
        ],

        '/seed' => [
            'controller' => 'database',
            'action' => 'seed',
            'auth' => 0,
            'name' => 'null',
        ]
    ];
}