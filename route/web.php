<?php
function getWebRoutes() {
    return [
        '/hoge' => [
            'controller' => 'hoge',
            'action' => 'hoge',
            'auth' => 0,
            'name' => 'hoge',
        ],
        '/home' => [
            'controller' => 'tweet',
            'action' => 'home',
            'auth' => 0,
            'name' => null,
        ],
        '/tweet' => [
            'controller' => 'tweet',
            'action' => 'tweet',
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