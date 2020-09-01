<?php

namespace App\System\Interfaces;

interface ModelInterface
{
    //Input---------------------------------------------------------------
    //なし

    //Output--------------------------------------------------------------
    //todo: executeの戻り値の型がわからん
    function smartExecute(string $sql, array $params, $strict = false);
    function fetch(string $sql, array $params, $strict = false);
    function fetchAll(string $sql, array $params, $strict = false);

    public function smartInsert(array $params);
    public function deleteById($id);
    public function smartCount($colum_name, $value);
    public function smartUpdate(array $params, array $cond);
}