<?php

namespace App\System\Classes\HTTP\Request;

use App\System\Classes\Exceptions\ValidateException;
use App\System\Interfaces\HTTP\RequestInterface;
use Valitron\Validator;

//Valitronをラッピングすることを諦め、直書きするクラス
abstract class Valitron
{
    // バリデーションルールの定義(ユーザーの実装が必須)
    abstract static function rules(Validator $v);

    // 項目名を任意の日本語に直す(任意)
    public static function labels(Validator $v){
        return $v;
    }

    // エラーが出た際のメインメッセージを変更する(任意)
    public static function errorMessage()
    {
        return '入力値に問題があります。';
    }

    public static function validate(RequestInterface $request)
    {
        $v = new Validator($request->getAllPost());

        // 静的遅延束縛
        $v = static::rules($v);
        $v = static::labels($v);

        if ($v->validate()) {
            return true;
        } else {
            throw new ValidateException($v->errors(), static::errorMessage());
        }
    }

}