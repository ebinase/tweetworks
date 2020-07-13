<?php
//FIXME:関数ではなく、もっとシンプルに配列だけを返したい。
function connectParam() {
    return [
        'dsn' => 'mysql:dbname=tweetworks; host=127.0.0.1; charset=utf8',
        'user' => 'root',
        'password' => 'root',
    ];

}