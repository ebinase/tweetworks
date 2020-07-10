<?php
function web() {
    return [
        '/hoge' => [
            'controller' => 'hoge',
            'action' => 'hoge',
            //todo: ルートの名前を持たせる→ 'name'=>'hoge'
        ],
        '/foo' => [
            'controller' => 'foo',
            'action' => 'foo',
        ]
    ];
}