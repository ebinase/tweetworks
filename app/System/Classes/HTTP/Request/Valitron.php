<?php

namespace App\System\Classes\HTTP\Request;

use App\System\Classes\Exceptions\ValidateException;
use App\System\Interfaces\HTTP\RequestInterface;
use Valitron\Validator;

//Valitronをラッピングすることを諦め、直書きするクラス
abstract class Valitron
{
    abstract static function rules(Validator $v);
    abstract static function labels(Validator $v);

    public static function validate(RequestInterface $request)
    {
        $v = new Validator($request->getAllPost());

        // 静的遅延束縛
        $v = static::rules($v);
        $v = static::labels($v);

        var_dump($v->validate());

        if ($v->validate()) {
            return true;
        } else {
            throw new ValidateException($v->errors(), '入力値に問題があります。');
        }
    }

}