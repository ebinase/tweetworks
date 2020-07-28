<?php

namespace App\System\Interfaces;

interface ModelInterface
{
    //Input---------------------------------------------------------------
    //なし

    //Output--------------------------------------------------------------
    //todo: executeの戻り値の型がわからん
    function smartExecute(string $sql, array $params);
    function fetch(string $sql, array $params);
    function fetchAll(string $sql, array $params);
}