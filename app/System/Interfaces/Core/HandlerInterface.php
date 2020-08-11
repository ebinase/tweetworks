<?php


namespace App\System\Interfaces\Core;


use App\System\Application;

interface HandlerInterface
{
    // Applicationが$Kernelでミドルウェアの流れで実行される際のインターフェース。
    function run(): Application;
}