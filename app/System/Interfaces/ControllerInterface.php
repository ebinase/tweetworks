<?php

namespace App\System\Interfaces;

use App\System\Application;

interface ControllerInterface
{
    function __construct(Application $application);

    //todo: 返り値がstringでいいのかチェック($contentの中身はHTML)
    function run(string $action_name, array $params): string;
}