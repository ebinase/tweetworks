<?php

namespace App\System\Classes\HTTP\Request;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ValidatorInterface;

// バリデータとリクエストなどのクラスとの互換性を保つレイヤークラス
// FIXME: 現状では使用できないので修正
abstract class BaseValidator implements ValidatorInterface
{

    protected $_request;

    protected $_rules;
    protected $_messages;
    protected $_labels;

    protected $_errors;

    public function __construct(RequestInterface $request)
    {
        $this->_request = $request;

        //フォームリクエスト風にオーバーライドされて設定がされていたらその値を登録
        $this->_rules = $this->rules();
        $this->_messages = $this->messages();
        $this->_labels = $this->labels();
    }

    /**
     * ルールを定義
     *
     * laravel風の形式(項目名 => 条件)
     * ['email' => ['required', 'email'] ]
     *
     * @return array
     */
    public function rules()
    {
        // オーバーライドされていなかったら空配列を返す
        return [];
    }

    public function messages()
    {
        // オーバーライドされていなかったら空配列を返す
        return [];
    }

    public function labels()
    {
        // オーバーライドされていなかったら空配列を返す
        return [];
    }

    /**
     * @param $rules
     */
    public function setRules($rules)
    {
        $this->_rules = $rules;
    }

    /**
     * @param $messages
     */
    public function setMessages($messages)
    {
        $this->_messages = $messages;
    }

    /**
     * @param $labels
     */
    public function setLabels($labels)
    {
        $this->_labels = $labels;
    }

    /**
     * 実際にバリデーションを実行し、その結果を返す。
     *
     * @return bool $result
     */
    public abstract function validate();

    /**
     * バリデーションエラーがあった場合にその値を配列に格納して返す。
     *
     * どんなバリデータを採用しようと、決まった形式(配列)で結果を返す。
     *
     * @param bool $default
     * @return void
     */
    public function getErrors($default = false)
    {
        return $this->_errors;
    }

}