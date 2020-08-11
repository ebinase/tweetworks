<?php

namespace App\System\Interfaces\Core;

use App\System\Application;

Interface KernelInterface
{
    // Applicationインスタンスを受け取り、クラスの取得などを行う
    public function __construct(Application $application);

    //Applicationクラスを受け取り、ミドルウェアなどの制御を行う。
    function handle(): void;
}