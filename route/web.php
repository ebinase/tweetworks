<?php
function getWebRoutes() {
    return [
        '/hoge' => [
            'controller' => 'hoge',
            'action' => 'hoge',
            'auth' => 0,
            'name' => 'hoge',
        ],
        '/foo/:random' => [
            'controller' => 'tweet',
            'action' => 'eweet',
            'auth' => 0,
            'name' => null,
        ],
        '/tweet' => [
            'controller' => 'tweet',
            'action' => 'tweet',
            'auth' => 1,
            'name' => 'hoge',
        ]
    ];
}