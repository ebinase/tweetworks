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
        '/foo' => [
            'controller' => 'foo',
            'action' => 'foo',
            //'auth' => true/false,
            // 'name' => 'hoge' / false
        ]
    ];
}