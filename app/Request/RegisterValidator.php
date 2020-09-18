<?php

namespace App\Request;

use App\System\Classes\HTTP\Request\Valitron;
use Valitron\Validator;

class RegisterValidator extends Valitron
{
    // TODO: 中身を書き換えて使用する

    public static function rules(Validator $v)
    {
        $v->rule('required', ['name', 'email', 'unique_name', 'password'])->message('{field}は必須です。');
        $v->rule('lengthMax', 'name', 30)->message('{field}は30文字以内です');

        $v->rule('lengthMax', 'email', 256)->message('{field}は256文字以内です。');
        $v->rule('email', 'email')->message('{field}の形式が正しくありません。');

        $v->rule('lengthMax', 'unique_name', 30)->message('{field}は30文字以内です。');
        $v->rule('slug', 'unique_name')->message('{field}に含めることができるのは英数字と(-)(_)だけです。');

        $v->rule('lengthMax', 'password', 30)->message('{field}は30文字以内です。');
        $v->rule('ascii', 'password')->message('{field}に含めることができるのは英数字と記号だけです。');

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
            'name' => 'アカウント名',
            'email' => 'メールアドレス',
            'unique_name' => 'ユーザーID',
            'password' => 'パスワード',
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