<?php

namespace App\Request;

use App\System\Classes\HTTP\Request\Valitron;
use Valitron\Validator;

class ProfileValidator extends Valitron
{
    // TODO: 中身を書き換えて使用する

    public static function rules(Validator $v)
    {
        $v->rule('required', ['name', 'bio'])->message('{field}は必須です。');
        $v->rule('lengthMax', 'name', 30)->message('{field}は30文字以内です');
        $v->rule('lengthMax', 'bio', 160)->message('{field}は160文字以内です');

        return $v;
    }

    /**
     * 上記のfieldの中身を英語から日本語に変更
     *
     * @param Validator $v
     * @return Validator
     */
    public static function labels(Validator $v)
    {
        $v->labels([
            'name' => '名前',
            'bio' => '自己紹介',
        ]);

        return $v;
    }

    /**
     * 例外クラスに渡すエラーメッセージ
     *
     * @return string
     */
    public static function errorMessage()
    {
        return '入力形式に間違いがあります。';
    }
}