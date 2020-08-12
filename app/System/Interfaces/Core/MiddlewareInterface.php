<?php

namespace App\System\Interfaces\Core;

use App\System\Application;

interface MiddlewareInterface
{
    //FIXME: そもそも現状ではメソッドチェーンを作ってないからApplicationを返す必要がない
    public function handle(Application $application): Application;
}