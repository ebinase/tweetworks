<?php
function getWebRoutes() {
    return [
        '/sign-up' => [
            'controller' => 'account',
            'action' => 'signUp',
            'auth' => 0,
            'name' => 'hoge',
        ],

        '/sign-up/confirm' => [
            'controller' => 'account',
            'action' => 'confirm',
            'auth' => 0,
            'name' => null,
        ],

        '/sign-up/register' => [
            'controller' => 'account',
            'action' => 'register',
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
            'controller' => 'migrate',
            'action' => 'migrate',
            'auth' => 0,
            'name' => 'null',
        ],

        '/refresh' => [
            'controller' => 'migrate',
            'action' => 'refresh',
            'auth' => 0,
            'name' => 'null',
        ]
    ];
}