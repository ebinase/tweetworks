<?php

namespace App\System\Interfaces\HTTP;

interface ValidatorInterface
{
    public function __construct(RequestInterface $request);

    // フォームリクエスト風に使う場合、予め定義しておいてコンストラクタ内で呼び出し
    public function rules();
    public function messages();
    public function labels();

    // Requestのメソッドとして呼び出す場合
    public function setRules($rules);
    public function setMessages($messages);
    public function setLabels($labels);

    public function validate();
    public function getErrors($default = false);
}