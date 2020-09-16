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

    /**
     * 上記のfieldの中身を英語から日本語に変更
     *
     * @param Validator $v
     * @return Validator
     */
    public static function labels(Validator $v)
    {
        $v->labels([
            'text' => 'ツイートのテキスト'
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
        return 'ツイートを投稿できませんでした。入力内容を確認してください。';
    }
}