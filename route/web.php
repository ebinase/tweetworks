<?php
function getWebRoutes() {
    return [
        '/hoge' => [
            'controller' => 'hoge',
            'action' => 'hoge',
            //todo: ログインの要不要とルートの名前を持たせる
            //'auth' => true/false,
            // 'name' => 'hoge' / false
        ],
        '/foo/:random' => [
            'controller' => 'tweet',
            'action' => 'tweet',
            //'auth' => true/false,
            // 'name' => 'hoge' / false
        ],
        '/tweet' => [
            'controller' => 'tweet',
            'action' => 'tweet',
            //'auth' => true/false,
            // 'name' => 'hoge' / false
        ]
    ];
}