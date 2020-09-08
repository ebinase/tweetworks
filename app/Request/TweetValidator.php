<?php


namespace App\Request;



use App\System\Classes\HTTP\Request\Valitron;
use Valitron\Validator;

class TweetValidator extends Valitron
{
    public static function rules(Validator $v)
    {
        $v->rule('required', ['text'])->message('{field}は必須です。');
        $v->rule('lengthMax', 'text', 140)->message('{field}は140文字以内です');

        return $v;
    }

    public static function labels(Validator $v)
    {
        $v->labels([
            'text' => 'ツイート'
        ]);

        return $v;
    }

    public static function errorMessage()
    {
        return 'ツイートを投稿できませんでした。入力内容を確認してください。';
    }
}