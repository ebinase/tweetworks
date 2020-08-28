<?php

namespace App\System\Classes\HTTP;

use App\System\Interfaces\HTTP\JsonResponseInterface;

class JsonResponse extends Response implements JsonResponseInterface
{

    /**
     * データをJSON形式に変換し、送信の準備をする。
     *
     * @param array $content
     */
    public function prepareJson($content)
    {
        //配列などのデータをJSON形式に変換してレスポンスボディに登録
        $this->setContent(json_encode($content));

        //ajax側でdataType:Jsonとしている場合は不要だが、明示的に記述
        $this->setHttpHeader('Content-type', 'application/json; charset=UTF-8');
    }
}